<?php

namespace App\Http\Controllers;

use App\Models\ExamType;
use App\Models\Order;
use App\Models\OrderPin;
use App\Models\Pin;
use App\Services\PaystackService;
use App\Services\PinAllocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'exam_type_id' => 'required|exists:exam_types,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $exam = ExamType::findOrFail($request->exam_type_id);

        $quantity = $request->quantity;
        $totalAmount = $exam->price * $quantity;

        $availableStock = Pin::where('exam_type_id', $exam->id)
            ->where('status', 'available')
            ->count();

        if ($availableStock < $quantity) {
            return back()->withErrors('Not enough cards in stock.');
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'exam_type_id' => $exam->id,
            'reference' => Order::generateReference(),
            'quantity' => $quantity,
            'amount' => $totalAmount,
        ]);

        return redirect(
            app(PaystackService::class)
                ->initialize(
                    auth()->user()->email,
                    $order->amount,
                    $order->reference,
                    route('payment.callback')
                )['data']['authorization_url']
        );
    }

    public function callback(Request $request)
    {
        $reference = $request->reference;

        $response = app(PaystackService::class)->verify($reference);

        if ($response['data']['status'] !== 'success') {
            abort(400, 'Payment failed');
        }

        $order = Order::where('reference', $reference)->firstOrFail();

        // Validate amount
        if ($response['data']['amount'] != ($order->amount * 100)) {
            throw new \Exception('Invalid payment amount');
        }

        // Validate email
        if ($response['data']['customer']['email'] !== $order->user->email) {
            throw new \Exception('Email mismatch');
        }

        app(PinAllocationService::class)->allocate($order);

        return redirect()->route('user.orders.success', $order)->with('success', 'Payment successful. PIN(s) assigned.');

    }
}
