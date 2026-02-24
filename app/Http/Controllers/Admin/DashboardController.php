<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pin;
use App\Models\User;
use App\Models\ExamType;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Revenue
        $totalRevenue = Order::where('status', 'paid')
            ->sum('amount');

        $todayRevenue = Order::where('status', 'paid')
            ->whereDate('paid_at', today())
            ->sum('amount');

        // Orders
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $paidOrders = Order::where('status', 'paid')->count();

        // PIN Stats
        $totalPins = Pin::count();
        $soldPins = Pin::where('status', 'sold')->count();
        $availablePins = Pin::where('status', 'available')->count();

        // Users
        $totalUsers = User::users()->count();

        // Low stock (less than 20 available)
        $lowStockExamTypes = ExamType::withCount([
            'pins as available_pins_count' => function ($q) {
                $q->where('status', 'available');
            }
        ])
            ->having('available_pins_count', '<', 20)
            ->get();

        // Recent Orders
        $recentOrders = Order::with('user', 'examType')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'todayRevenue',
            'totalOrders',
            'pendingOrders',
            'paidOrders',
            'totalPins',
            'soldPins',
            'availablePins',
            'totalUsers',
            'lowStockExamTypes',
            'recentOrders'
        ));
    }
}
