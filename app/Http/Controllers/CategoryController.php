<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::latest('updated_at')->paginate(10);
        return view('backoffice.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $request->validated();

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return Redirect::route('category.index')->with(['alert-toast' => true, 'type' => 'success', 'message' => 'Category created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $request->validated();

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return Redirect::route('category.index')->with(['alert-toast' => true, 'type' => 'success', 'message' => 'Category updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Check if the category is associated with any product
        if ($category->product()->exists()) {
            return redirect()->route('category.index')->with([
                'alert-toast' => true,
                'type' => 'danger',
                'message' => 'Category cannot be deleted because it is in use by one or more product.'
            ]);
        }

        $category->delete();
        return Redirect::route('category.index')->with(['alert-toast' => true, 'type' => 'success', 'message' => 'Category deleted successfully']);
    }
}
