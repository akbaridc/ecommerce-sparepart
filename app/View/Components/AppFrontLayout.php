<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\Category;

class AppFrontLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $categories = Category::orderBy('name')->get(['name', 'slug']);
        return view('layouts.frontstore.app', compact('categories'));
    }
}
