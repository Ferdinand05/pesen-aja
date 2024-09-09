<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResources;

class DashboardController extends Controller
{
    //

    public function index()
    {

        // cari bulan ini dan 2 bulan kebelakang
        $thisMonth = Carbon::now()->month;
        $thisMonthName = Carbon::now()->monthName;

        $twoMonthsAgo = Carbon::now()->subMonth(1)->month;
        $twoMonthsAgoName = Carbon::now()->subMonth(1)->monthName;

        $threeMonthsAgo = Carbon::now()->subMonth(2)->month;
        $threeMonthsAgoName = Carbon::now()->subMonth(2)->monthName;



        // hitung total tiap bulannya
        $revenueThisMonth = Order::whereMonth('created_at', $thisMonth)->whereNot('status', 'menunggu pembayaran')->sum('total');
        $revenueTwoMonthAgo = Order::whereMonth('created_at', $twoMonthsAgo)->whereNot('status', 'menunggu pembayaran')->sum('total');
        $revenueThreeMonthAgo = Order::whereMonth('created_at', $threeMonthsAgo)->whereNot('status', 'menunggu pembayaran')->sum('total');

        // hitung jumlah Orderan
        $orderThisMonth = Order::whereMonth('created_at', $thisMonth)->whereNot('status', 'menunggu pembayaran')->count();
        $orderTwoMonthAgo = Order::whereMonth('created_at', $twoMonthsAgo)->whereNot('status', 'menunggu pembayaran')->count();
        $orderThreeMonthAgo = Order::whereMonth('created_at', $threeMonthsAgo)->whereNot('status', 'menunggu pembayaran')->count();

        $dataChart = [
            'months' => [$threeMonthsAgoName, $twoMonthsAgoName, $thisMonthName],
            'revenue' => [$revenueThreeMonthAgo, $revenueTwoMonthAgo, $revenueThisMonth],
            'orders' => [$orderThreeMonthAgo, $orderTwoMonthAgo, $orderThisMonth]
        ];


        $orders = Order::where('status', 'dibayar')->get();


        return Inertia::render('Dashboard/Dashboard', [
            'productCount' => Product::count(),
            'orderCount' => Order::whereNot('status', 'menunggu pembayaran')->count(),
            'revenue' => Order::whereNot('status', 'menunggu pembayaran')->whereMonth('created_at', Carbon::now())->sum('total'),
            'orderSelesai' => Order::with('payment')->where('status', 'selesai')->whereDate('created_at', Carbon::now())->get(),
            'todayRevenue' => Order::whereDate('created_at', Carbon::now())->where('status', 'selesai')->sum('total'),
            'dataChart' => $dataChart,
            'orders' => OrderResources::collection($orders)
        ]);
    }
}
