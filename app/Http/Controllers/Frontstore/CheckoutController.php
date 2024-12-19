<?php

namespace App\Http\Controllers\Frontstore;

use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

    public function checkoutStore(Request $request)
    {
        $carts = $request->carts;
        $address = $request->mainAddress;

        DB::beginTransaction();

        try {
            $order = [
                'code' => $request->codeTransaction,
                'name' => $address['fullname'],
                'phone' => $address['phone'],
                'address' => $address['address']
            ];



            $orderId = Order::create($order)->id;

            foreach ($carts as $cart) {
                $price = $cart['price'] - (($cart['price'] * $cart['discount']) / 100);

                $productId = Product::where('name', $cart['product'])->first()->id ?? NULL;

                OrderDetail::create([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'product_name' => $cart['product'],
                    'price' => $cart['price'],
                    'discount' => $cart['discount'],
                    'qty' => $cart['qty'],
                ]);

                Product::where('id', $productId)->decrement('stock', $cart['qty']);
            }

            DB::commit();
            return response()->json('success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage());
        }
    }
}
