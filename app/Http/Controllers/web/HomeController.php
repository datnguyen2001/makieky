<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use App\Mail\OrderTrackingMail;
use App\Models\AddressModel;
use App\Models\BannerModel;
use App\Models\CategoryModel;
use App\Models\FooterModel;
use App\Models\IntroduceModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\PromoteModel;
use App\Models\ProvinceModel;
use App\Models\SettingModel;
use App\Models\TrademarkModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function home()
    {
        $banner = BannerModel::where('display',1)->orderBy('created_at','desc')->get();
        $introduce = IntroduceModel::where('display',1)->first();
        $promote = PromoteModel::where('display',1)->orderBy('created_at','desc')->limit(3)->get();
        $product = ProductModel::join('category', 'products.category_id', '=', 'category.id')
            ->join('trademark', 'products.trademark_id', '=', 'trademark.id')
            ->where('products.display', 1)
            ->where('category.display', 1)
            ->where('trademark.display', 1)
            ->where('products.quantity','>', 0)
            ->select('products.id','products.slug', 'products.name', 'products.price', 'products.src')
            ->orderBy('products.created_at', 'desc')
            ->limit(4)
            ->get();


        return view('web.home.index',compact('banner','introduce','promote','product'));
    }

    public function detail($slug)
    {
        $data = IntroduceModel::where('slug',$slug)->first();

        return view('web.introduce.home',compact('data'));
    }


    public function category($slug,Request $request)
    {
        $productQuery = ProductModel::join('category', 'products.category_id', '=', 'category.id')
            ->join('trademark', 'products.trademark_id', '=', 'trademark.id')
            ->where('products.display', 1)
            ->where('category.display', 1)
            ->where('trademark.display', 1)
            ->where('products.quantity','>', 0)
            ->select('products.id','products.slug', 'products.name', 'products.price', 'products.src')
            ->orderBy('products.created_at', 'desc');

        $nameCate = 'Tất cả sản phẩm';

        if ($slug != 'all') {
            $productQuery->where('category.slug', $slug);
            $category = CategoryModel::where('slug',$slug)->first();
            $nameCate = $category->name;
        }

        $sort = $request->get('sort', 'newest');

        switch ($sort) {
            case 'newest':
                $productQuery->orderBy('products.created_at', 'desc');
                $nameSort = 'Hàng mới về';
                break;
            case 'bestselling':
                $productQuery->orderBy('products.sold', 'desc');
                $nameSort = 'Bán chạy nhất';
                break;
            case 'price_asc':
                $productQuery->orderBy('products.price', 'asc');
                $nameSort = 'Giá thấp đến cao';
                break;
            case 'price_desc':
                $productQuery->orderBy('products.price', 'desc');
                $nameSort = 'Giá cao đến thấp';
                break;
            case 'name_asc':
                $productQuery->orderBy('products.name', 'asc');
                $nameSort = 'Name A-Z';
                break;
            default:
                $productQuery->orderBy('products.created_at', 'desc');
                $nameSort = 'Hàng mới về';
                break;
        }

        $listData = $productQuery->paginate(16);

        return view('web.category.index',compact('listData','slug','nameSort','nameCate'));
    }

    public function trademark($slug,Request $request)
    {
        $productQuery = ProductModel::join('category', 'products.category_id', '=', 'category.id')
            ->join('trademark', 'products.trademark_id', '=', 'trademark.id')
            ->where('products.display', 1)
            ->where('category.display', 1)
            ->where('trademark.display', 1)
            ->where('products.quantity','>', 0)
            ->select('products.id','products.slug', 'products.name', 'products.price', 'products.src')
            ->orderBy('products.created_at', 'desc');

        $nameTrademark = 'Tất cả sản phẩm';

        if ($slug != 'all') {
            $productQuery->where('trademark.slug', $slug);
            $trademark = TrademarkModel::where('slug',$slug)->first();
            $nameTrademark = $trademark->name;
        }

        $sort = $request->get('sort', 'newest');

        switch ($sort) {
            case 'newest':
                $productQuery->orderBy('products.created_at', 'desc');
                $nameSort = 'Hàng mới về';
                break;
            case 'bestselling':
                $productQuery->orderBy('products.sold', 'desc');
                $nameSort = 'Bán chạy nhất';
                break;
            case 'price_asc':
                $productQuery->orderBy('products.price', 'asc');
                $nameSort = 'Giá thấp đến cao';
                break;
            case 'price_desc':
                $productQuery->orderBy('products.price', 'desc');
                $nameSort = 'Giá cao đến thấp';
                break;
            case 'name_asc':
                $productQuery->orderBy('products.name', 'asc');
                $nameSort = 'Name A-Z';
                break;
            default:
                $productQuery->orderBy('products.created_at', 'desc');
                $nameSort = 'Hàng mới về';
                break;
        }

        $listData = $productQuery->paginate(16);

        return view('web.trademark.index',compact('listData','slug','nameSort','nameTrademark'));
    }

    public function orderTracking()
    {
        return view('web.order-tracking.index');
    }

    public function searchOrder(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email phải có định dạng hợp lệ.',
        ]);

        $order = OrderModel::with(['province', 'district', 'ward'])->where('order_code', $request->order_code)->first();

        if (!$order) {
            return back()->with('error', 'Mã đơn hàng không tồn tại!');
        }
        $user = User::where('email',$request->email)->first();

        if (!$user){
            return back()->with('error', 'Email không khớp với mã đơn hàng!');
        }

        if ($order->user_id != $user->id) {
            return back()->with('error', 'Email không khớp với mã đơn hàng!');
        }
        $orderItems = OrderItemModel::where('order_id', $order->id)->get();
        foreach ($orderItems as $item) {
            $item->product = ProductModel::find($item->product_id);
        }

        Mail::to($request->email)->send(new OrderTrackingMail($order,$orderItems));

        return back()->with('success', 'Thông tin đơn hàng đã được gửi vào email của bạn!');
    }

    public function contact()
    {
        $contact = SettingModel::first();

        return view('web.contact.index',compact('contact'));
    }

    public function sendEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'phone' => ['required', 'regex:/^(0|\+84)[0-9]{9}$/'],
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email phải có định dạng hợp lệ.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không hợp lệ. Đảm bảo số điện thoại bắt đầu với 0 và có 10 chữ số.',
        ]);

        Mail::to($request->email)->send(new ContactFormMail($request));

        return back()->with('success', 'Tin nhắn của bạn đã được gửi đi!');
    }

    public function buyNow(Request $request)
    {
        $user = Auth::guard('web')->user();
        $listAddress = AddressModel::where('user_id',$user->id)->get();
        $addressDetail = AddressModel::where('user_id',$user->id)->where('is_default',1)->first();
        $province = ProvinceModel::all();

        $cart = Session::get('cart', []);

        $product = ProductModel::find($request->productId);
        $totalPrice = $request->quantity * $product->price;
        $totalQuantity =$request->quantity;

        $cartItems = [
            [
                'product' => $product,
                'quantity' => $request->quantity,
                'totalPrice' => $totalPrice
            ]
        ];

        $order = OrderModel::where('user_id',$user->id)->where('is_select',0)->get();
        if ($order){
            foreach ($order as $orders){
                OrderItemModel::where('order_id',$orders->id)->delete();
                $orders->delete();
            }
        }

        return view('web.payment.index',compact('user','listAddress','addressDetail','province','cartItems', 'totalPrice',
            'totalQuantity'));
    }

    public function pay()
    {
        $user = Auth::guard('web')->user();
        $listAddress = AddressModel::where('user_id',$user->id)->get();
        $addressDetail = AddressModel::where('user_id',$user->id)->where('is_default',1)->first();
        $province = ProvinceModel::all();

        $cart = Session::get('cart', []);

        $totalPrice = 0;
        $totalQuantity = 0;

        $cartItems = [];

        foreach ($cart as $productId => $item) {
            $product = ProductModel::find($productId);

            if ($product) {
                $item['product'] = $product;
                $item['totalPrice'] = $item['quantity'] * $product->price;

                $totalPrice += $item['totalPrice'];
                $totalQuantity += $item['quantity'];

                $cartItems[] = $item;
            }
        }

        $order = OrderModel::where('user_id',$user->id)->where('is_select',0)->get();
        if ($order){
            foreach ($order as $orders){
                OrderItemModel::where('order_id',$orders->id)->delete();
                $orders->delete();
            }
        }

        return view('web.payment.index',compact('user','listAddress','addressDetail','province','cartItems', 'totalPrice',
            'totalQuantity'));
    }

    public function createOrderUser(Request $request)
    {
        try {
            $user = Auth::user();
            $carts = Session::get('cart', []);
            $address = AddressModel::where('user_id',$user->id)->where('is_default',1)->first();
            $total_money = $request->get('total_money');

            $order = new OrderModel();
            $order['order_code'] = 'HS'.rand(0, 99999).$order->id;
            $order['user_id'] = $user->getAuthIdentifier();
            $order['name'] = $address->name;
            $order['phone'] = $address->phone;
            $order['province_id'] = $address->province_id;
            $order['district_id'] = $address->district_id;
            $order['ward_id'] = $address->ward_id;
            $order['detail_address'] = $address->detail_address;
            $order['total_money'] = $total_money;
            $order['status'] = 0;
            $order->save();

            foreach ($carts as $item) {
                $this->saveOrderItem($order, $item);
            }

            if ($request->type_payment == 1) {
                $order['type_payment'] = 1;
                $order['is_select'] = 1;
                $order->save();
                foreach ($carts as $item) {
                    $product = ProductModel::find($item['product_id']);
                    $product->quantity = $product->quantity - $item['quantity'];
                    $product->sold += $item['quantity'];
                    $product->save();
                }
                Session::forget('cart');

                return redirect()->route('home')->with(['success' => 'Tạo đơn hàng thành công.']);
            }elseif ($request->type_payment == 2){
                $this->checkoutByVnPay($total_money,$order,$user);
            }
        } catch (\Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function checkoutByVnPay ($total,$order,$user)
    {
        session_start();
        $_SESSION['user'] = $user;
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = url('thanh-toan/thanh-cong');
        $vnp_TmnCode = $_ENV['VNP_TMN_CODE'];
        $vnp_HashSecret = $_ENV['VNP_HASH_SECRET'];

        $vnp_TxnRef = $order->order_code;
        $vnp_OrderInfo = 'Khách hàng '.$order->name.' - '.$order->phone.' đã mua hàng';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $total * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        die();
    }

    public function successOrderVnPay ()
    {
        session_start();
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $vnp_HashSecret = $_ENV['VNP_HASH_SECRET'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $order = OrderModel::where('order_code',$_GET['vnp_TxnRef'])->first();
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash == $vnp_SecureHash) {
            if ($_GET['vnp_ResponseCode'] == '00') {
                $order->type_payment = 2;
                $order->is_select = 1;
                $order->save();
                $orderItem = OrderItemModel::where('product_id',$order->id)->get();
                foreach ($orderItem as $order_item){
                    $product = ProductModel::find($order_item->product_id);
                    $product->quantity = $product->quantity - $order_item->quantity;
                    $product->sold += $order_item->quantity;
                    $product->save();
                }
                Session::forget('cart');
                $msg = ['success' => 'Thanh toán thành công.'];
            }
            else {
                $msg = ['error' => 'Thanh toán thất bại.Vui lòng thanh toán lại'];
            }
        } else {
            $msg = ['error' => 'Thanh toán thất bại.Vui lòng thanh toán lại'];
        }
        return redirect()->route('home')->with($msg);
    }

    public function saveOrderItem($order, $item){
        try {
            $product = ProductModel::find($item['product_id']);

            $order_item = new OrderItemModel();
            $order_item['order_id'] = $order->id;
            $order_item['product_id'] = $item['product_id'];
            $order_item['quantity'] = $item['quantity'];
            $order_item['price_product'] = $product->price;
            $order_item->save();

            return $order_item;
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }

    public function post($slug)
    {
        $data = FooterModel::where('slug',$slug)->first();

        return view('web.introduce.home',compact('data'));
    }
}
