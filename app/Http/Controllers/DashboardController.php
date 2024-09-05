<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        $revenueThisMonth = Order::whereMonth('created_at', $thisMonth)->sum('total');
        $revenueTwoMonthAgo = Order::whereMonth('created_at', $twoMonthsAgo)->sum('total');
        $revenueThreeMonthAgo = Order::whereMonth('created_at', $threeMonthsAgo)->sum('total');

        // hitung jumlah Orderan
        $orderThisMonth = Order::whereMonth('created_at', $thisMonth)->count();
        $orderTwoMonthAgo = Order::whereMonth('created_at', $twoMonthsAgo)->count();
        $orderThreeMonthAgo = Order::whereMonth('created_at', $threeMonthsAgo)->count();

        $dataChart = [
            'months' => [$threeMonthsAgoName, $twoMonthsAgoName, $thisMonthName],
            'revenue' => [$revenueThreeMonthAgo, $revenueTwoMonthAgo, $revenueThisMonth],
            'orders' => [$orderThreeMonthAgo, $orderTwoMonthAgo, $orderThisMonth]
        ];



        return Inertia::render('Dashboard/Dashboard', [
            'productCount' => Product::count(),
            'orderCount' => Order::where('status', 'dibayar')->orWhere('status', 'selesai')->count(),
            'revenue' => Order::whereMonth('created_at', Carbon::now())->sum('total'),
            'orderSelesai' => Order::with('payment')->where('status', 'selesai')->whereDate('created_at', Carbon::now())->get(),
            'todayRevenue' => Order::whereDate('created_at', Carbon::now())->sum('total'),
            'dataChart' => $dataChart
        ]);
    }
}
