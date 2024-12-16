<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::with('category')
            ->latest('updated_at')
            ->paginate(10);
        // dd($products);

        return view('backoffice.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get(['id', 'name']);
        return view('backoffice.product.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $request->validated();

        $image = NULL;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'short_description' => $request->short_description,
            'price' => (int)$request->price,
            'stock' => (int)$request->stock,
            'image' => $image,
        ]);

        return to_route('backoffice.product.index')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        if (!$product) abort(404);

        $categories = Category::orderBy('name')->get(['id', 'name']);
        return view('backoffice.product.form', compact('categories', 'product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if (!$product) abort(404);

        $categories = Category::orderBy('name')->get(['id', 'name']);
        return view('backoffice.product.form', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $request->validated();

        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products', 'public');

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
        }

        $dataUpdated = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'short_description' => $request->short_description,
            'price' => $request->price,
            'stock' => $request->stock
        ];

        if ($image) $dataUpdated['image'] = $image;

        $product->update($dataUpdated);

        return to_route('backoffice.product.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $imageFile = $product->image;
        $product->delete();
        // if ($imageFile) Storage::disk('public')->delete($imageFile);
        return to_route('backoffice.product.index')->with('success', 'Product deleted successfully');
    }

    public function restore(): RedirectResponse
    {
        Product::withTrashed()->restore();
        return to_route('backoffice.product.index')->with('success', 'Product restored successfully');
    }
}
