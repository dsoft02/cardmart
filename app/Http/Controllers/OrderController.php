<?php

namespace App\Http\Controllers;

use App\Mail\OrderReceiptMail;
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

        if (!$reference) {
            return redirect()->route('user.orders.index')
                ->with('error', 'Invalid payment reference.');
        }

        $order = Order::where('reference', $reference)->first();

        if (!$order) {
            return redirect()->route('user.orders.index')
                ->with('error', 'Order not found.');
        }

        $response = app(PaystackService::class)->verify($reference);

        if (!$response || !isset($response['data'])) {
            return redirect()->route('user.orders.index')
                ->with('error', 'Unable to verify payment.');
        }

        if ($response['data']['status'] !== 'success') {

            $order->update([
                'status' => 'failed'
            ]);

            return redirect()
                ->route('user.orders.index')
                ->with('error', 'Payment was cancelled or failed.');
        }

        // Prevent double processing
        if ($order->status === 'paid') {
            return redirect()->route('user.orders.success', $order);
        }

        // Validate amount
        if ($response['data']['amount'] != ($order->amount * 100)) {
            $order->update(['status' => 'failed']);

            return redirect()->route('user.orders.index')
                ->with('error', 'Invalid payment amount.');
        }

        // Validate email
        if ($response['data']['customer']['email'] !== $order->user->email) {
            $order->update(['status' => 'failed']);

            return redirect()->route('user.orders.index')
                ->with('error', 'Email mismatch detected.');
        }

        try {

            app(PinAllocationService::class)->allocate($order);

            // Send receipt email
            $order->refresh();
            \Mail::to($order->user->email)
                ->send(new OrderReceiptMail($order));

        } catch (\Throwable $e) {

            \Log::error('PIN allocation failed after successful payment', [
                'order_id' => $order->id,
                'reference' => $order->reference,
                'user_id' => $order->user_id,
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            $order->update(['status' => 'failed']);

            return redirect()->route('user.orders.index')
                ->with('error', 'Payment received but allocation failed. Contact support.');
        }

        return redirect()
            ->route('user.orders.success', $order)
            ->with('success', 'Payment successful. PIN(s) assigned.');
    }
}
