<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderPin;
use App\Models\Pin;
use Illuminate\Support\Facades\DB;

class PinAllocationService
{
    /**
     * Allocate pins for a paid order
     *
     * @throws \Exception
     */
    public function allocate(Order $order): void
    {
        DB::transaction(function () use ($order) {

            // Lock order row
            $order->refresh();

            if ($order->status !== 'pending') {
                return;
            }

            $pins = Pin::where('exam_type_id', $order->exam_type_id)
                ->where('status', 'available')
                ->orderBy('id')
                ->lockForUpdate()
                ->take($order->quantity)
                ->get();

            if ($pins->count() < $order->quantity) {
                throw new \Exception('Insufficient stock');
            }

            // Mark order as paid
            $order->update([
                'status' => 'paid',
                'paid_at' => now()
            ]);

            foreach ($pins as $pin) {
                $pin->update([
                    'status' => 'sold',
                    'sold_to' => $order->user_id,
                    'sold_at' => now()
                ]);

                OrderPin::create([
                    'order_id' => $order->id,
                    'pin_id' => $pin->id,
                ]);
            }
        });
    }
}
