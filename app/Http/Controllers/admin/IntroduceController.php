<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\IntroduceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class IntroduceController extends Controller
{
    public function index()
    {
        $titlePage = 'Danh sách bài viết';
        $page_menu = 'introduce';
        $page_sub = null;
        $listData = IntroduceModel::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.introduce.index', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
    }

    public function create ()
    {
        try{
            $titlePage = 'Thêm bài viết';
            $page_menu = 'introduce';
            $page_sub = null;
            return view('admin.introduce.create', compact('titlePage', 'page_menu', 'page_sub'));
        }catch (\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function store (Request $request)
    {
        try{
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $imagePath = Storage::url($file->store('introduce', 'public'));
            }else{
                return back()->with(['info'=>'Vui lòng thêm ảnh để tiếp tục']);
            }
            if ($request->get('display') == 'on'){
                $display = 1;
                IntroduceModel::where('display', 1)->update(['display' => 0]);
            }else{
                $display = 0;
            }
            $introduce = new IntroduceModel([
                'src' => $imagePath,
                'display' => $display,
                'name' => $request->get('name'),
                'slug' => Str::slug($request->get('name')),
                'describe' => $request->get('describe'),
                'content' => $request->get('content'),
            ]);
            $introduce->save();

            return redirect()->route('admin.introduce.index')->with(['success' => 'Tạo dữ liệu thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function delete ($id)
    {
        $introduce = IntroduceModel::find($id);
        if (isset($introduce->src) && Storage::exists(str_replace('/storage', 'public', $introduce->src))) {
            Storage::delete(str_replace('/storage', 'public', $introduce->src));
        }
        $introduce->delete();

        return redirect()->route('admin.introduce.index')->with(['success'=>"Xóa dữ liệu thành công"]);
    }

    public function edit ($id)
    {
        try{
            $introduce = IntroduceModel::find($id);
            if (empty($introduce)) {
                return back()->with(['error' => 'Dữ liệu không tồn tại']);
            }
            $titlePage = 'Sửa bài viết';
            $page_menu = 'introduce';
            $page_sub = null;

            return view('admin.introduce.edit', compact('titlePage', 'page_menu', 'page_sub', 'introduce'));
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function update ($id, Request $request)
    {
        try{
            $introduce = IntroduceModel::find($id);
            if (empty($introduce)){
                return back()->with(['error' => 'Dữ liệu không tồn tại']);
            }
            if ($request->hasFile('file')){
                $file = $request->file('file');
                $imagePath = Storage::url($file->store('introduce', 'public'));
                if (isset($introduce->src) && Storage::exists(str_replace('/storage', 'public', $introduce->src))) {
                    Storage::delete(str_replace('/storage', 'public', $introduce->src));
                }
                $introduce->src = $imagePath;
            }
            if ($request->get('display') == 'on'){
                $display = 1;
                IntroduceModel::where('display', 1)->where('id','!=',$id)->update(['display' => 0]);
            }else{
                $display = 0;
            }
            $introduce->name = $request->get('name');
            $introduce->slug = Str::slug($request->get('name'));
            $introduce->describe = $request->get('describe');
            $introduce->content = $request->get('content');
            $introduce->display = $display;
            $introduce->save();

            return redirect()->route('admin.introduce.index')->with(['success' => 'Cập nhật dữ liệu thành công']);
        }catch (\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
