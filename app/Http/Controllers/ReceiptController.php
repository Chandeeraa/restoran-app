<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function show(Order $order)
    {
        // Load the order with its items and table
        $order->load(['items.menu', 'table']);
        $setting = StoreSetting::first();
        
        return view('cashier.receipt', compact('order', 'setting'));
    }

    public function print(Order $order)
    {
        // Load the order with its items and table
        $order->load(['items.menu', 'table']);
        $setting = StoreSetting::first();
        
        // Pass a specific variable to trigger auto-print in JS if needed
        return view('cashier.receipt', [
            'order' => $order,
            'setting' => $setting,
            'autoPrint' => true
        ]);
    }
}
