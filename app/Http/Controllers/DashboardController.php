<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //

    public function index()
    {
        return Inertia::render('Dashboard/Dashboard', [
            'productCount' => Product::count(),
            'orderCount' => Order::count(),
            'revenue' => Order::sum('total')
        ]);
    }
}
