<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $titlePage = 'Danh mục sản phẩm';
        $page_menu = 'category';
        $page_sub = null;
        $listData = CategoryModel::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.category.index', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
    }

    public function create()
    {
        try {
            $titlePage = 'Thêm danh mục';
            $page_menu = 'category';
            $page_sub = null;

            return view('admin.category.create', compact('titlePage', 'page_menu', 'page_sub'));
        } catch (\Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $display = $request->get('display') == 'on' ? 1 : 0;

            $category = new CategoryModel([
                'name' => $request->get('title'),
                'slug' => Str::slug($request->get('title')),
                'display' => $display,
            ]);
            $category->save();

            return redirect()->route('admin.category.index')->with(['success' => 'Tạo dữ liệu thành công']);
        } catch (\Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function delete($id)
    {
        $category = CategoryModel::find($id);
        $category->delete();

        return redirect()->route('admin.category.index')->with(['success'=>"Xóa dữ liệu thành công"]);
    }

    public function edit($id)
    {
        try {
            $data = CategoryModel::find($id);
            if (empty($data)) {
                return back()->with(['error' => 'Dữ liệu không tồn tại']);
            }
            $titlePage = 'Cập nhật danh mục';
            $page_menu = 'category';
            $page_sub = null;

            return view('admin.category.edit', compact('titlePage', 'page_menu', 'page_sub', 'data'));
        } catch (\Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $category = CategoryModel::find($id);

            $display = $request->get('display') == 'on' ? 1 : 0;

            $category->name = $request->get('title');
            $category->slug = Str::slug($request->get('title'));
            $category->display = $display;
            $category->save();

            return redirect()->route('admin.category.index')->with(['success' => 'Cập nhật dữ liệu thành công']);
        } catch (\Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
