<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cartNumber()
    {
        $cart = Session::get('cart', []);
        $number = 0;
        if (!empty($cart)) {
            $productIds = array_column($cart, 'product_id');
            $products = ProductModel::whereIn('id', $productIds)->get()->keyBy('id');
            foreach ($cart as $key => $item) {
                $product = $products->get($item['product_id']);
                if (!$product || $item['quantity'] > $product->quantity) {
                    unset($cart[$key]);
                }
                $number += $item['quantity'];
            }

            Session::put('cart', $cart);
        }

        return response()->json(['number' => $number]);
    }

    public function getCart()
    {
        $cart = Session::get('cart', []);
        $totalQuantity = 0;
        $totalPrice = 0;

        foreach ($cart as $productId => $item) {

            $product = ProductModel::find($productId);

            if ($product) {
                if ($item['quantity'] > $product->quantity) {
                    unset($cart[$productId]);
                    continue;
                }

                $cart[$productId]['cart_id'] = $productId;
                $cart[$productId]['product_id'] = $product->id;
                $cart[$productId]['name'] = $product->name;
                $cart[$productId]['image'] = $product->src;
                $cart[$productId]['price'] = $product->price;
                $cart[$productId]['totalPrice'] = $item['quantity'] * $product->price;

                $totalPrice += $item['quantity'] * $product->price;
                $totalQuantity += $item['quantity'];
            } else {
                unset($cart[$productId]);
            }
        }

        return view('web.cart.index', compact('cart', 'totalQuantity', 'totalPrice'));
    }

    public function addCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $product = ProductModel::find($productId);

        $cart = Session::get('cart', []);

        $totalQuantityInCart = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
        $totalRequestedQuantity = $totalQuantityInCart + $quantity;

        if ($totalRequestedQuantity > $product->quantity) {
            return response()->json(['error' => 'Số lượng sản phẩm còn lại không đủ']);
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product_id' => $productId,
                'quantity' => $quantity
            ];
        }

        Session::put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function updateCart(Request $request, $id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $product = ProductModel::find($id);

            if ($request->quantity > $product->quantity) {
                return redirect()->back()->with('error', 'Số lượng sản phẩm còn lại không đủ');
            }

            $cart[$id]['quantity'] = $request->quantity;

            Session::put('cart', $cart);


            return redirect()->route('get-cart');
        }

        return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật giỏ hàng');
    }


    public function removeItem($id)
    {
        $cart = Session::get('cart', []);
        $productId = $id;

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
            toastr()->success('Xóa sản phẩm ra khỏi giỏ hàng thành công');

            return redirect()->route('get-cart');
        }

        toastr()->error('Xóa sản phẩm ra khỏi giỏ hàng không thành công');

        return back();
    }

    public function clearCart()
    {
        Session::forget('cart');
        toastr()->success('Xóa giỏ hàng thành công');

        return redirect()->route('get-cart');
    }

}
