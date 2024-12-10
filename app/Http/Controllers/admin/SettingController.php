<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SettingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $titlePage = 'Cài đặt chung';
        $page_menu = 'setting';
        $page_sub = null;
        $data = SettingModel::first();

        return view('admin.setting.index',compact('titlePage','page_menu','page_sub','data'));
    }

    public function save(Request $request){
        $setting = SettingModel::first();
        if ($setting){
            if ($request->hasFile('file')){
                $file = $request->file('file');
                $imagePath = Storage::url($file->store('banner', 'public'));
                if (isset($setting->logo) && Storage::exists(str_replace('/storage', 'public', $setting->logo))) {
                    Storage::delete(str_replace('/storage', 'public', $setting->logo));
                }
                $setting->logo = $imagePath;
            }

            $setting->phone = $request->get('phone');
            $setting->address = $request->get('address');
            $setting->map = $request->get('map');
            $setting->email = $request->get('email');
            $setting->facebook = $request->get('facebook');
            $setting->instagram = $request->get('instagram');
            $setting->youtube = $request->get('youtube');
            $setting->line = $request->get('line');
            $setting->save();
        }else{
            $imagePath = null;
            if ($request->hasFile('file')){
                $file = $request->file('file');
                $imagePath = Storage::url($file->store('banner', 'public'));
            }
            $setting = new SettingModel([
                'phone'=>$request->get('phone'),
                'address'=>$request->get('address'),
                'map'=>$request->get('map'),
                'facebook'=>$request->get('facebook'),
                'email'=>$request->get('email'),
                'instagram'=>$request->get('instagram'),
                'logo'=>$imagePath,
                'youtube'=>$request->get('youtube'),
                'line'=>$request->get('line'),
            ]);
            $setting->save();
        }

        return redirect()->back()->with(['success'=>"Lưu thông tin thành công"]);
    }
}
