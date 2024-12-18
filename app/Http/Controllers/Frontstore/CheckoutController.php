<?php

namespace App\Http\Controllers\Frontstore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function cart(): View
    {
        return view('frontstore.cart.index');
    }

    public function checkout(): View
    {
        return view('frontstore.checkout.index');
    }

    public function cartShow(Request $request)
    {
        $products = Product::whereIn('id', $request->productId)->get(['id', 'name', 'price', 'stock', 'discount', 'image'])->transform(function ($product) {
            $product->image = asset('storage/' . $product->image);
            return $product;
        });
        return response()->json($products);
    }
}
