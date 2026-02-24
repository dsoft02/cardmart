<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'examType'])
            ->whereNotNull('paid_at')
            ->latest('paid_at');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('reference', 'like', "%{$request->search}%")
                    ->orWhereHas('user', function ($uq) use ($request) {
                        $uq->where('name', 'like', "%{$request->search}%")
                            ->orWhere('email', 'like', "%{$request->search}%");
                    });
            });
        }

        $payments = $query->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Order $order)
    {
        abort_if(!$order->paid_at, 404);

        $order->load(['user', 'examType', 'pins']);

        return view('admin.payments.show', compact('order'));
    }
}
