<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()
            ->orders()
            ->with('examType')
            ->latest();

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to . ' 23:59:59',
            ]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15);

        return view('user.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load('pins');

        return view('user.orders.show', compact('order'));
    }

    public function success(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load('examType', 'pins');

        return view('user.orders.success', compact('order'));
    }

    public function invoice(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_if($order->status !== 'paid', 403);

        $order->load('examType', 'pins', 'user');

        $pdf = Pdf::loadView('user.orders.invoice', compact('order'));

        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'dpi' => 96,
            'fontHeightRatio' => 1.2,
            'isFontSubsettingEnabled' => true,
        ]);

        $filename = 'invoice-'.$order->reference.'.pdf';

        return $pdf->download($filename);

    }

    public function cards(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('pins', 'examType');

        return view('user.orders.cards', compact('order'));
    }
}
