<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use App\Models\TrademarkModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $titlePage = 'Admin | Danh Sách Sản Phẩm';
        $page_menu = 'product';
        $page_sub = null;
        if (isset($request->key_search)) {
            $listData = ProductModel::where('name', 'like', '%' . $request->get('key_search') . '%')
                ->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $listData = ProductModel::orderBy('created_at', 'desc')->paginate(20);
        }
        foreach ($listData as $item) {
            $category = CategoryModel::find($item->category_id);
            $item->category_name = $category->name;
        }
        return view('admin.product.index', compact('titlePage', 'page_menu', 'listData', 'page_sub'));
    }

    public function create()
    {
        $titlePage = 'Admin | Danh Sách Sản Phẩm';
        $page_menu = 'product';
        $page_sub = null;
        $category = CategoryModel::where('display', 1)->get();
        $trademark = TrademarkModel::where('display', 1)->get();

        return view('admin.product.create', compact('titlePage', 'page_menu', 'page_sub', 'category', 'trademark'));
    }

    public function store(Request $request)
    {
        try {
            if ($request->hasFile('file_product')) {
                $file = $request->file('file_product');
                $imagePath = Storage::url($file->store('product', 'public'));
            } else {
                return back()->with(['info' => 'Vui lòng thêm ảnh để tiếp tục']);
            }
            $display = $request->get('display') == 'on' ? 1 : 0;

            $product = new ProductModel([
                'name' => $request->get('name'),
                'slug' => Str::slug($request->get('name')),
                'describe' => $request->get('describe'),
                'src' => $imagePath,
                'category_id' => $request->get('category_id'),
                'trademark_id' => $request->get('trademark_id'),
                'price' => str_replace(",", "", $request->get('price')),
                'content' => $request->get('content'),
                'ingredients' => $request->get('ingredients'),
                'quantity' => $request->get('quantity'),
                'display' => $display,
            ]);
            $product->save();
            $this->add_img_product($request, $product->id);

            return \redirect()->route('admin.product.index')->with(['success' => 'Tạo mới sản phẩm thành công']);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function delete($id)
    {
        $product = ProductModel::find($id);
        if (isset($product->src) && Storage::exists(str_replace('/storage', 'public', $product->src))) {
            Storage::delete(str_replace('/storage', 'public', $product->src));
        }

        $product_img = ProductImageModel::where('product_id', $id)->get();
        foreach ($product_img as $img) {
            if (isset($img->src) && Storage::exists(str_replace('/storage', 'public', $img->src))) {
                Storage::delete(str_replace('/storage', 'public', $img->src));
            }
            $img->delete();
        }

        $product->delete();

        return \redirect()->route('admin.product.index')->with(['success' => 'Xóa sản phẩm thành công']);
    }

    public function edit($id)
    {
        $titlePage = 'Admin | Danh Sách Sản Phẩm';
        $page_menu = 'product';
        $page_sub = null;
        $product = ProductModel::find($id);
        $category = CategoryModel::where('display', 1)->get();
        $trademark = TrademarkModel::where('display', 1)->get();
        $product_img = ProductImageModel::where('product_id', $id)->get();

        return view('admin.product.edit', compact( 'titlePage', 'page_menu', 'page_sub',
            'category', 'product', 'product_img', 'trademark'));
    }

    public function update(Request $request, $id)
    {
        try {
            $product = ProductModel::find($id);

            $display = $request->get('display') == 'on' ? 1 : 0;
            if (isset($request->file_product)) {
                $file = $request->file('file_product');
                $imagePath = Storage::url($file->store('product', 'public'));
                if (isset($product->src) && Storage::exists(str_replace('/storage', 'public', $product->src))) {
                    Storage::delete(str_replace('/storage', 'public', $product->src));
                }
                $product->src = $imagePath;
            }
            $product->category_id = $request->get('category_id');
            $product->trademark_id = $request->get('trademark_id');
            $product->name = $request->get('name');
            $product->slug = Str::slug($request->get('name'));
            $product->describe = $request->get('describe');
            $product->price = str_replace(",", "", $request->get('price'));
            $product->quantity = $request->get('quantity');
            $product->content = $request->get('content');
            $product->ingredients = $request->get('ingredients');
            $product->display = $display;

            $product->save();
            $this->add_img_product($request, $product->id);

            return \redirect()->route('admin.product.index')->with(['success' => 'Cập nhập sản phẩm thành công']);
        } catch (\Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function deleteImg(Request $request)
    {
        try {
            $img = ProductImageModel::find($request->get('id'));
            if (isset($img->src) && Storage::exists(str_replace('/storage', 'public', $img->src))) {
                Storage::delete(str_replace('/storage', 'public', $img->src));
            }
            $img->delete();
            $data['status'] = true;
            return $data;
        } catch (\Exception $exception) {
            $data['status'] = false;
            $data['msg'] = $exception->getMessage();
            return $data;
        }
    }

    public function add_img_product($request, $product_id)
    {
        try {
            if ($request->hasFile('images')) {
                $file = $request->file('images');
                foreach ($file as $value) {
                    $imagePath = Storage::url($value->store('product', 'public'));
                    $image_invest = new ProductImageModel([
                        'product_id' => $product_id,
                        'src' => $imagePath,
                    ]);
                    $image_invest->save();
                }
                return true;
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

}
