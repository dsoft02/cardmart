<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ExamType;
use App\Models\Pin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        [$from, $to] = $this->resolveDateRange($request);

        $data = $this->buildReportData($from, $to);

        return view('admin.reports.index', array_merge($data, [
            'from' => $from,
            'to' => $to,
        ]));
    }

    /*
    |--------------------------------------------------------------------------
| Shared Report Builder
    |--------------------------------------------------------------------------
    */

    private function buildReportData($from, $to): array
    {
        $ordersQuery = Order::whereBetween('created_at', [$from, $to]);

        $totalRevenue = (clone $ordersQuery)
            ->where('status', 'paid')
            ->sum('amount');

        $totalOrders = (clone $ordersQuery)->count();

        $paidOrders = (clone $ordersQuery)
            ->where('status', 'paid')
            ->count();

        $soldPins = Pin::where('status', 'sold')
            ->whereBetween('sold_at', [$from, $to])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Previous Period Growth
        |--------------------------------------------------------------------------
        */

        $periodDays = $from->diffInDays($to) + 1;

        $previousFrom = (clone $from)->subDays($periodDays);
        $previousTo = (clone $to)->subDays($periodDays);

        $previousRevenue = Order::where('status', 'paid')
            ->whereBetween('created_at', [$previousFrom, $previousTo])
            ->sum('amount');

        $revenueGrowth = 0;

        if ($previousRevenue > 0) {
            $revenueGrowth = (($totalRevenue - $previousRevenue) / $previousRevenue) * 100;
        }


        /*
        |--------------------------------------------------------------------------
        | Daily Revenue & Orders
        |--------------------------------------------------------------------------
        */

        $revenueDataRaw = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(amount) as total')
        )
            ->where('status', 'paid')
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $orderDataRaw = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total')
        )
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('date')
            ->orderBy('date')
            ->get();


        $revenueLabels = [];
        $revenueData = [];
        $orderData = [];

        $period = Carbon::parse($from)->copy();

        while ($period <= $to) {

            $date = $period->format('Y-m-d');
            $revenueLabels[] = $period->format('d M');

            $revenueData[] = $revenueDataRaw
                ->firstWhere('date', $date)?->total ?? 0;

            $orderData[] = $orderDataRaw
                ->firstWhere('date', $date)?->total ?? 0;

            $period->addDay();
        }


        /*
        |--------------------------------------------------------------------------
        | Exam Performance
        |--------------------------------------------------------------------------
        */

        $examSales = ExamType::withCount([
            'pins as sold_count' => function ($query) use ($from, $to) {
                $query->where('status', 'sold')
                    ->whereBetween('sold_at', [$from, $to]);
            }
        ])
            ->get()
            ->sortByDesc('sold_count');

        return [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'paidOrders' => $paidOrders,
            'soldPins' => $soldPins,
            'revenueGrowth' => round($revenueGrowth, 2),
            'revenueLabels' => $revenueLabels,
            'revenueData' => $revenueData,
            'orderData' => $orderData,
            'examSales' => $examSales,
            'examChartLabels' => $examSales->pluck('name'),
            'examChartData' => $examSales->pluck('sold_count'),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Resolve Date Range
    |--------------------------------------------------------------------------
    */

    private function resolveDateRange(Request $request): array
    {
        if ($request->preset) {

            switch ($request->preset) {

                case 'today':
                    $from = Carbon::today();
                    $to = Carbon::today();
                    break;

                case '7days':
                    $from = Carbon::today()->subDays(6);
                    $to = Carbon::today();
                    break;

                case '30days':
                    $from = Carbon::today()->subDays(29);
                    $to = Carbon::today();
                    break;

                case 'thismonth':
                    $from = Carbon::now()->startOfMonth();
                    $to = Carbon::now()->endOfMonth();
                    break;

                default:
                    $from = Carbon::now()->startOfMonth();
                    $to = Carbon::now()->endOfMonth();
            }

        } else {

            $from = $request->filled('from')
                ? Carbon::parse($request->from)
                : Carbon::now()->startOfMonth();

            $to = $request->filled('to')
                ? Carbon::parse($request->to)
                : Carbon::now()->endOfMonth();
        }

        return [$from->startOfDay(), $to->endOfDay()];
    }

    /*
    |--------------------------------------------------------------------------
    | CSV Export (Filtered)
    |--------------------------------------------------------------------------
    */

    public function exportCsv(Request $request): StreamedResponse
    {
        [$from, $to] = $this->resolveDateRange($request);

        return response()->stream(function () use ($from, $to) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Reference',
                'User',
                'Exam Type',
                'Amount',
                'Status',
                'Paid At'
            ]);

            Order::with(['user', 'examType'])
                ->whereBetween('created_at', [$from, $to])
                ->chunk(500, function ($orders) use ($file) {

                    foreach ($orders as $order) {

                        fputcsv($file, [
                            $order->reference,
                            $order->user->name ?? '',
                            $order->examType->name ?? '',
                            $order->amount,
                            $order->status,
                            $order->paid_at
                        ]);
                    }
                });

            fclose($file);

        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="cardmart-report.csv"',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PDF Export (Filtered + Full Data)
    |--------------------------------------------------------------------------
    */

    public function exportPdf(Request $request)
    {
        [$from, $to] = $this->resolveDateRange($request);

        $data = $this->buildReportData($from, $to);

        $orders = Order::with(['user', 'examType'])
            ->where('status', 'paid')
            ->whereBetween('created_at', [$from, $to])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf', array_merge($data, [
            'orders' => $orders,
            'from' => $from,
            'to' => $to,
        ]));

        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'dpi' => 96,
            'fontHeightRatio' => 1.2,
            'isFontSubsettingEnabled' => true,
        ]);

        return $pdf->download('cardmart-report.pdf');
    }
}
