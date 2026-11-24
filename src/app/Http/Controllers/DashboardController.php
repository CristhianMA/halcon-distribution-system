<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('role');

        $stats = [
            'total_orders' => Order::count(),
            'active_employees' => User::where('is_active', true)->count(),
        ];

        return view('dashboard', compact('user', 'stats'));
    }

    public function module(Request $request, string $module)
    {
        $user = $request->user()->load('role');
        $orders = Order::with('customer')->latest()->take(15)->get();

        $titles = [
            'sales' => 'Sales Module — Customer Orders',
            'purchasing' => 'Purchasing Module — Missing Materials Support',
            'warehouse' => 'Warehouse Module — Order Preparation',
            'route' => 'Route Module — Routed Orders & Delivery Evidence',
        ];

        $title = $titles[$module] ?? 'Department Module';

        return view('modules.department', compact('user', 'module', 'title', 'orders'));
    }
}