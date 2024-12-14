<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;


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

        $icon = $request->file('icon')->store('categories', 'public');

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $icon
        ]);

        return to_route('backoffice.category.index')->with(alertResponse("success", "Category created successfully"));
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

        $icon = null;
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon')->store('categories', 'public');

            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }
        }

        $dataUpdated = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        if ($icon) $dataUpdated['icon'] = $icon;

        $category->update($dataUpdated);

        return to_route('backoffice.category.index')->with(alertResponse("success", "Category updated successfully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Check if the category is associated with any product
        if ($category->product()->exists()) {
            return redirect()->route('backoffice.category.index')->with(alertResponse("error", "Category cannot be deleted because it is in use by one or more product."));
        }

        $iconFile = $category->icon;

        $category->delete();
        if ($iconFile) Storage::disk('public')->delete($iconFile);
        return to_route('backoffice.category.index')->with(alertResponse("success", "Category deleted successfully"));
    }
}
