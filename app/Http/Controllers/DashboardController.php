<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategory = Category::count();
        $totalProduct = Product::count();
        return view('backoffice.dashboard.index', compact('totalCategory', 'totalProduct'));
    }
}
