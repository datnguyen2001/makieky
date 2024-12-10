<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login()
    {
        return view('web.login');
    }

    public function loginSubmit(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors([
                'email' => 'Thông tin đăng nhập không đúng.',
            ])->withInput();
        }

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->back()->withErrors([
                'password' => 'Mật khẩu không đúng.',
            ])->withInput();
        }

        return redirect()->route('home');
    }

    public function register()
    {
        return view('web.register');
    }

    public function registered(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
            'password_confirmation' => 'required|same:password',
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Vui lòng nhập một địa chỉ email hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',

            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ cái thường, một chữ cái hoa và một chữ số.',

            'password_confirmation.required' => 'Bạn phải nhập lại mật khẩu.',
            'password_confirmation.same' => 'Mật khẩu nhập lại không khớp.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }

    public function forgotPassword()
    {
        return view('web.forgot_password');
    }

    public function submitForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Vui lòng nhập một địa chỉ email hợp lệ.',
            'email.exists' => 'Email không tồn tại trong hệ thống.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $newPassword = Str::random(8);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($newPassword);
        $user->save();

        Mail::to($request->email)->send(new ResetPasswordMail($newPassword));

        return redirect()->route('login')->with('success', 'Mật khẩu mới đã được gửi về email của bạn!');
    }

}
