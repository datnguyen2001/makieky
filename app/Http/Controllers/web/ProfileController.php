<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\AddressModel;
use App\Models\DistrictModel;
use App\Models\OrderModel;
use App\Models\ProvinceModel;
use App\Models\WardModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile()
    {
        $data = Auth::guard('web')->user();
        $active_menu = 1;

        return view('web.account.index',compact('data','active_menu'));
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'regex:/^(0[3|5|7|8|9])+([0-9]{8})$/'],
        ], [
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Số điện thoại không hợp lệ. Số điện thoại phải bắt đầu bằng 0 và có 10 hoặc 11 chữ số.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->date_of_birth = $request->birth_date;

        if ($request->hasFile('avatar')) {
            if (isset($user->avatar) && Storage::exists(str_replace('/storage', 'public', $user->avatar))) {
                Storage::delete(str_replace('/storage', 'public', $user->avatar));
            }
            $file = $request->file('avatar');
            $imagePath = Storage::url($file->store('avatar', 'public'));
            $user->avatar = $imagePath;
        }

        $user->save();

        return back()->with('success', 'Thông tin của bạn đã được cập nhật.');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|current_password',
            'newPassword' => 'required|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
            'confNewpassword' => 'required|same:newPassword',
        ],[
            'password.required' => 'Mật khẩu hiện tại là bắt buộc.',
            'password.current_password' => 'Mật khẩu hiện tại không chính xác.',
            'newPassword.required' => 'Mật khẩu mới là bắt buộc.',
            'newPassword.min' => 'Mật khẩu mới phải dài ít nhất 8 ký tự.',
            'newPassword.regex' => 'Mật khẩu mới phải chứa ít nhất một chữ cái hoa, một chữ cái thường và một chữ số.',
            'confNewpassword.required' => 'Xác nhận mật khẩu mới là bắt buộc.',
            'confNewpassword.same' => 'Mật khẩu xác nhận phải trùng khớp với mật khẩu mới.',
            ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $user = Auth::user();


        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Mật khẩu hiện tại không chính xác.'])->withInput();
        }

        $user->password = Hash::make($request->newPassword);
        $user->save();

        return back()->with('success', 'Mật khẩu đã được thay đổi thành công.');
    }

    public function address()
    {
        $data = AddressModel::with(['province', 'district', 'ward'])
            ->where('user_id', Auth::id())->get();

        $province = ProvinceModel::all();
        $active_menu = 2;

        return view('web.account.address',compact('data','province','active_menu'));
    }

    public function addAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/^(0[3,5,7,8,9])+([0-9]{8})$/',
        ], [
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Số điện thoại không hợp lệ. Số điện thoại phải bắt đầu bằng 0 và có 10 hoặc 11 chữ số.',
        ]);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            toastr()->error($firstError);
            return back();
        }


        $user = Auth::user();
        if ($request->is_default) {
            AddressModel::where('user_id', Auth::id())->update(['is_default' => 0]);
        }

        $address = new AddressModel();
        $address->user_id = $user->id;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->province_id = $request->province_id;
        $address->district_id = $request->district_id;
        $address->ward_id = $request->ward_id;
        $address->detail_address = $request->detail_address;
        $address->is_default = $request->is_default ?? 0;
        $address->save();

        return back()->with('success', 'Địa chỉ đã được thêm thành công.');
    }

    public function updateAddress(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/^(0[3,5,7,8,9])+([0-9]{8})$/',
        ], [
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Số điện thoại không hợp lệ. Số điện thoại phải bắt đầu bằng 0 và có 10 hoặc 11 chữ số.',
        ]);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            toastr()->error($firstError);
            return back();
        }

        if ($request->is_default) {
            AddressModel::where('user_id', Auth::id())->update(['is_default' => 0]);
        }

        $address = AddressModel::findOrFail($id);

        $address->update([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'province_id' => $request->get('province_id'),
            'district_id' => $request->get('district_id'),
            'ward_id' => $request->get('ward_id'),
            'detail_address' => $request->get('detail_address'),
            'is_default' => $request->get('is_default') ?? 0,
        ]);

        return redirect()->back()->with('success', 'Cập nhật địa chỉ thành công');
    }

    public function deleteAddress($id)
    {
        $address = AddressModel::find($id);

        if ($address) {
            $address->delete();
            toastr()->success('Địa chỉ đã được xóa thành công.');
        } else {
            toastr()->error('Địa chỉ không tồn tại.');
        }

        return back();
    }

    public function getDistricts($provinceId)
    {
        $districts = DistrictModel::where('province_id', $provinceId)->get();
        return response()->json(['districts' => $districts]);
    }

    public function getWards($districtId)
    {
        $wards = WardModel::where('district_id', $districtId)->get();
        return response()->json(['wards' => $wards]);
    }

    public function orderHistory(Request $request)
    {
        $user = Auth::user();
        $orderCode = $request->input('order-number');

        if ($orderCode) {
            $listData = OrderModel::where('user_id', $user->id)
                ->where('order_code', 'LIKE', '%' . $orderCode . '%')
                ->where('is_select',1)
                ->get();
        } else {
            $listData = OrderModel::where('user_id', $user->id)->where('is_select',1)->get();
        }
        $active_menu = 3;

        return view('web.account.order',compact('listData','active_menu'));
    }

    public function getOrderDetails($orderId)
    {
        $order = OrderModel::with('orderItems.product')->find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Đơn hàng không tồn tại.'], 404);
        }

        return view('web.account.order_detail', compact('order'));
    }

}
