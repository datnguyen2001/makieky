<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DistrictModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\ProvinceModel;
use App\Models\User;
use App\Models\WardModel;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getDataOrder(Request $request, $status)
    {
        try {
            $titlePage = 'Quản lý đơn hàng';
            $page_menu = 'order';
            $page_sub = 'order';
            $listData = OrderModel::query();
            if ($status !== 'all') {
                $listData = $listData->where('status', $status);
            }
            $key_search = $request->get('search');
            if (isset($key_search)) {
                $listData = $listData->where(function ($listData) use ($key_search) {
                    return $listData->where('name', 'like', '%' . $key_search . '%')->orWhere('phone', 'like', '%' . $key_search . '%')
                        ->orWhere('order_code', 'LIKE', '%' . $key_search . '%');
                });
            }
            $listData = $listData->orderBy('updated_at', 'desc')->paginate(10);
            foreach ($listData as $item) {
                $item->status_name = $this->checkStatusOrder($item);
                $province = ProvinceModel::where('province_id',$item->province_id)->first();
                $district = DistrictModel::where('district_id',$item->district_id)->first();
                $ward = WardModel::where('wards_id',$item->ward_id)->first();
                $item->full_address = $item->detail_address.', '.$ward->name.', '.$district->name.', '.$province->name;
            }
            $order_all = OrderModel::count();
            $order_pending = OrderModel::where('status', 0)->count();
            $order_confirm = OrderModel::where('status', 1)->count();
            $order_delivery = OrderModel::where('status', 2)->count();
            $order_complete = OrderModel::where('status', 3)->count();
            $order_cancel = OrderModel::where('status', 4)->count();
            $return_refund = OrderModel::where('status', 5)->count();
            return view('admin.order.index', compact('titlePage', 'page_menu', 'listData', 'page_sub', 'order_pending', 'order_confirm',
                'order_delivery', 'order_complete', 'order_cancel', 'status', 'order_all','return_refund'));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public function orderDetail($order_id)
    {
        try {
            $titlePage = 'Chi tiết đơn hàng';
            $page_menu = 'order';
            $page_sub = 'order';
            $listData = OrderModel::find($order_id);
            if ($listData) {
                $user = User::find($listData->user_id);
                $order_item = OrderItemModel::where('order_id', $order_id)->get();
                foreach ($order_item as $item) {
                    $product = ProductModel::find($item->product_id);
                    $item->product_name = $product->name;
                    $item->product_image = $product->src;
                }
                $listData['status_name'] = $this->checkStatusOrder($listData);
                $listData['order_item'] = $order_item;
                return view('admin.order.detail', compact('titlePage', 'page_menu', 'listData', 'page_sub','user'));
            }
        } catch (\Exception $exception) {
            return back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function statusOrder($order_id, $status_id)
    {
        try {
            $order = OrderModel::find($order_id);
            if ($order) {
                $order->status = $status_id;
                if ($status_id == 4) {
                    $this->updateQuantityProductWhenCancel($order);
                }
                $order->save();
                if ($status_id == 5) {
                    $this->updateQuantityProductWhenCancel($order);
                }
                return \redirect()->route('admin.order.index', [$status_id])->with(['success' => 'Xét trạng thái đơn hàng thành công']);
            }
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public function checkStatusOrder($item)
    {

        if ($item->status == 0) {
            $val_status = 'Chờ xác nhận';
        } elseif ($item->status == 1) {
            $val_status = 'Đã xác nhận';
        } elseif ($item->status == 2) {
            $val_status = 'Đang vận chuyển';
        } elseif ($item->status == 3) {
            $val_status = 'Đã hoàn thành';
        } elseif ($item->status == 4) {
            $val_status = 'Đã hủy';
        } else {
            $val_status = 'Trả hàng hoàn tiền';
        }

        return $val_status;
    }

    public function updateQuantityProductWhenCancel($order)
    {
        $order_item = OrderItemModel::where('order_id', $order->id)->get();
        foreach ($order_item as $value) {
            $product = ProductModel::find($value->product_id);
            if (isset($product)) {
                $product->quantity = $product->quantity + $value->quantity;
                $product->sold = $product->sold - $value->quantity;
                $product->save();
            }
        }
        return true;
    }
}
