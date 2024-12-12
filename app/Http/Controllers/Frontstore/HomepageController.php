<?php

namespace App\Http\Controllers\Frontstore;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category;
use App\Models\Product;

class HomepageController extends Controller
{
    public function index(Request $request): View
    {
        $categoriesProducts = Category::with('product')->when($request->slug, function ($query) use ($request) {
            $query->where('slug', $request->slug);
        })->when($request->query('search'), function ($query) use ($request) {
            $search = $request->query('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('product', function ($query) use ($search) {
                    // Search in product fields
                    $query->where('description', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%")
                        ->orWhere('price', 'like', "%{$search}%")
                        ->orWhere('stock', 'like', "%{$search}%");
                });
        })->orderBy('name')->get();

        return view('frontstore.homepage', compact('categoriesProducts'));
    }

    public function product(Request $request): View
    {
        $product = Product::with('category')->where('slug', $request->productSlug)->firstOrFail();
        return view('frontstore.product', compact('product'));
    }
}
