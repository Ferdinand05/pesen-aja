<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResources;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('status', 'dibayar')->get();
        Inertia::share('orders.data', OrderResources::collection($orders));
        return Inertia::render('Order/OrderView', ['orders' => OrderResources::collection($orders)]);
    }

    public function selesaiOrder(Request $request)
    {
        $order = Order::where('order_code', $request->order_code)->first();

        if ($order->status == 'dibayar') {
            $order->update([
                'status' => 'selesai'
            ]);
        } else {
            return back()->with('message', 'Order belum dibayarkan');
        }
    }


    public function orderHistory(Request $request)
    {

        if ($request->startDate || $request->endDate) {

            $orderHistory = Order::whereDate('created_at', $request->startDate)->orWhereDate('created_at', $request->endDate)
                ->orderBy('status', 'asc')->latest()->paginate(5)->withQueryString();
        } elseif ($request->startDate && $request->endDate) {
            $orderHistory = Order::whereDate('created_at', '>=', $request->startDate)->WhereDate('created_at', '<=', $request->endDate)
                ->orderBy('status', 'asc')->latest()->paginate(5)->withQueryString();
        } else {
            $orderHistory = Order::orderBy('status', 'asc')->latest()->paginate(5)->withQueryString();
        }



        return Inertia::render('Order/OrderHistoryView', ['orderHistory' => $orderHistory]);
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
