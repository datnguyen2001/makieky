<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function detailProduct($slug)
    {
        $data = ProductModel::with(['category', 'trademark'])->where('slug',$slug)->first();
        $productImage = ProductImageModel::where('product_id',$data->id)->get();
        $related_products = ProductModel::join('category', 'products.category_id', '=', 'category.id')
            ->join('trademark', 'products.trademark_id', '=', 'trademark.id')
            ->where('products.display', 1)
            ->where('products.id','!=', $data->id)
            ->where('category.display', 1)
            ->where('trademark.display', 1)
            ->where('products.quantity','>', 0)
            ->select('products.id','products.slug', 'products.name', 'products.price', 'products.src')
            ->orderBy('products.created_at', 'desc')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('web.product.index',compact('data','productImage','related_products'));
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $listData = ProductModel::where('name', 'like', '%' . $search . '%')
            ->where('display', 1)->where('quantity','>', 0)
            ->paginate(16);

        return view('web.search.index', compact('listData','search'));
    }

}
