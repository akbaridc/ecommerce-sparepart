<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategory = Category::count();
        $totalProduct = Product::count();
        $totalBanner = Product::count();
        $totalTransaction = Order::count();

        $transactionDaily = OrderDetail::whereDate('created_at', date('Y-m-d'))
            ->with('product')
            ->selectRaw('SUM(qty * (price - (price * discount / 100))) as total')
            ->value('total');

        $transactionWeek = OrderDetail::whereDate('created_at', '>=', date('Y-m-d', strtotime('-7 days')))
            ->with('product')
            ->selectRaw('SUM(qty * (price - (price * discount / 100))) as total')
            ->value('total');

        $transactionMonthly = OrderDetail::whereMonth('created_at', date('m'))
            ->with('product')
            ->selectRaw('SUM(qty * (price - (price * discount / 100))) as total')
            ->value('total');

        $transactionYear = OrderDetail::whereYear('created_at', date('Y'))
            ->with('product')
            ->selectRaw('SUM(qty * (price - (price * discount / 100))) as total')
            ->value('total');

        $data = [
            'totalCategory' => $totalCategory,
            'totalProduct' => $totalProduct,
            'totalBanner' => $totalBanner,
            'totalTransaction' => $totalTransaction,
            'sales' => [
                'transactionDaily' => $transactionDaily,
                'transactionWeek' => $transactionWeek,
                'transactionMonthly' => $transactionMonthly,
                'transactionYear' => $transactionYear,
            ]
        ];

        return view('backoffice.dashboard.index', $data);
    }
}
