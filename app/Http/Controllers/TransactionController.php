<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(): View
    {
        $transactions = Order::with('order_detail', 'order_detail.product')
            ->latest('created_at')
            ->paginate(10);

        return view('backoffice.transaction.index', compact('transactions'));
    }

    public function show(Order $order)
    {
        $order->load(['order_detail', 'order_detail.product']);
        return view('backoffice.transaction.form', compact('order'));
    }
}
