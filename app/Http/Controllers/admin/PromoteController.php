<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PromoteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromoteController extends Controller
{
    public function index()
    {
        $titlePage = 'Danh sách quản bá';
        $page_menu = 'promote';
        $page_sub = null;
        $listData = PromoteModel::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.promote.index', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
    }

    public function create ()
    {
        try{
            $titlePage = 'Thêm quảng bá';
            $page_menu = 'promote';
            $page_sub = null;
            return view('admin.promote.create', compact('titlePage', 'page_menu', 'page_sub'));
        }catch (\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function store (Request $request)
    {
        try{
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $imagePath = Storage::url($file->store('promote', 'public'));
            }else{
                return back()->with(['info'=>'Vui lòng thêm ảnh để tiếp tục']);
            }
            $display = $request->get('display') == 'on' ? 1 : 0;
            $promote = new PromoteModel([
                'name' => $request->get('name'),
                'src' => $imagePath,
                'display' => $display,
                'link' => $request->get('link'),
            ]);
            $promote->save();
            return redirect()->route('admin.promote.index')->with(['success' => 'Tạo dữ liệu thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function delete ($id)
    {
        $promote = PromoteModel::find($id);
        if (isset($promote->src) && Storage::exists(str_replace('/storage', 'public', $promote->src))) {
            Storage::delete(str_replace('/storage', 'public', $promote->src));
        }
        $promote->delete();
        return redirect()->route('admin.promote.index')->with(['success'=>"Xóa dữ liệu thành công"]);
    }

    public function edit ($id)
    {
        try{
            $promote = PromoteModel::find($id);
            if (empty($promote)) {
                return back()->with(['error' => 'Dữ liệu không tồn tại']);
            }
            $titlePage = 'Sửa quảng bá';
            $page_menu = 'promote';
            $page_sub = null;
            return view('admin.promote.edit', compact('titlePage', 'page_menu', 'page_sub', 'promote'));
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function update ($id, Request $request)
    {
        try{
            $promote = PromoteModel::find($id);
            if (empty($promote)){
                return back()->with(['error' => 'Dữ liệu không tồn tại']);
            }
            if ($request->hasFile('file')){
                $file = $request->file('file');
                $imagePath = Storage::url($file->store('promote', 'public'));
                if (isset($promote->src) && Storage::exists(str_replace('/storage', 'public', $promote->src))) {
                    Storage::delete(str_replace('/storage', 'public', $promote->src));
                }
                $promote->src = $imagePath;
            }
            $display = $request->get('display') == 'on' ? 1 : 0;
            $promote->name = $request->get('name');
            $promote->link = $request->get('link');
            $promote->display = $display;
            $promote->save();
            return redirect()->route('admin.promote.index')->with(['success' => 'Cập nhật dữ liệu thành công']);
        }catch (\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
