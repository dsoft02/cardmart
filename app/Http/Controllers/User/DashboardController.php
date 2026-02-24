<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = $user->orders()
            ->with('examType')
            ->latest()
            ->take(10)
            ->get();

        return view('user.dashboard', [
            'orders' => $orders,
            'totalOrders' => $user->orders()->count(),
            'totalPins' => $user->orders()->sum('quantity'),
            'lastOrder' => $user->orders()->latest()->first()
        ]);

    }

}
