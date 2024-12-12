<?php

namespace App\Http\Controllers\Frontstore;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HomepageController extends Controller
{
    public function index(): View
    {
        return view('frontstore.homepage');
    }
}
