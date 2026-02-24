<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = auth()->user()
            ->orders()
            ->where('status', 'paid')
        ->whereNotNull('paid_at')
        ->latest('paid_at')
            ->paginate(15);

        return view('user.payments.index', compact('payments'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        return view('user.payments.show', compact('order'));
    }
}
