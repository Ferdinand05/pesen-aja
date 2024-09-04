<?php

namespace App\Http\Controllers;

use App\Models\TemporaryOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class TemporaryOrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => ['required', 'max:100'],
            'table_number' => ['required']
        ]);

        $session_id = Session::getId();


        $checkProduct = TemporaryOrder::where('table_number', $request->table_number)->where('session_id', $session_id)->where('customer_name', $request->customer_name)->where('product_id', $request->product_id)->first();
        if ($checkProduct) {
            $checkProduct->increment('quantity', $request->quantity);
        } else {
            $temp = TemporaryOrder::create([
                'session_id' => $session_id,
                'customer_name' => $request->customer_name,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'table_number' => $request->table_number
            ]);
        }

        session([
            'session_id' => $session_id,
            'customer_name' => $request->customer_name,
            'table_number' => $request->table_number
        ]);


        return to_route('home');
    }

    public function deleteOrder(Request $request)
    {
        $session_id = Session::getId();

        $checkProduct = TemporaryOrder::where('table_number', $request->table_number)->where('session_id', $session_id)->where('customer_name', $request->customer_name)->where('product_id', $request->product_id)->first();

        if ($checkProduct->quantity > 1) {
            $checkProduct->decrement('quantity', 1);
        }
    }

    public function cancelOrder(Request $request)
    {
        $session_id = Session::getId();
        $checkProduct = TemporaryOrder::where('table_number', $request->table_number)->where('session_id', $session_id)->where('customer_name', $request->customer_name)->where('product_id', $request->product_id)->first();
        $checkProduct->delete();
    }
}
