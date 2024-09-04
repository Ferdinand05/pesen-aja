<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\TemporaryOrder;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'customer_name' => 'required',
            'table_number' => 'required',
        ]);

        DB::beginTransaction();

        // ambil order items 
        $orderItems = $request->userOrders;

        try {

            //* Hitung total
            $total = 0;
            foreach ($orderItems as $item) {
                $total += ($item['quantity'] * $item['product']['price']);
            }


            //* Input Order
            $orderCode = Str::random(20);
            $order = Order::create([
                'order_code' => $orderCode,
                'customer_name' => $request->customer_name,
                'table_number' => $request->table_number,
                'total' => $total,
                'status' => 'menunggu pembayaran'
            ]);

            $item_details = [];

            //* masukan order items
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['product']['price']
                ]);

                $item_details[] = [
                    'id' => $item['product_id'],
                    'price' => $item['product']['price'],
                    'quantity' => $item['quantity'],
                    'name' => $item['product']['name'],
                    'merchant_name' => 'PesenAja'
                ];

                TemporaryOrder::where('customer_name', $request->customer_name)->where('table_number', $request->table_number)
                    ->where('product_id', $item['product_id'])->delete();
            }


            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $order->order_code,
                    'gross_amount' => intval($total),
                ),
                'customer_details' => [
                    'first_name' => $request->customer_name,
                    'last_name' =>  '| Table ' . $request->table_number
                ],
                'item_details' => $item_details
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $payment =   Payment::create([
                'order_id' => $order->id,
                'amount' => $total,
                'transaction_id' => $snapToken,
                'payment_date' => Carbon::now('Asia/Jakarta'),
            ]);


            // jika semua berhasil
            Session::forget(['customer_name', 'table_number', 'clientKey', 'snapToken']);

            DB::commit();

            return redirect()->back()->with('snapToken', $snapToken);
            // 
        } catch (Exception $e) {
            // jika ada kesalahan
            DB::rollback();

            return $e->getMessage();
        }
    }


    public function updateTransactionMessage(Request $request)
    {

        // setelah pembayaran dilakukan Update Payment 

        $message = $request->message;

        // update status order
        $order = Order::where('order_code', $message["order_id"])->first();
        $order->update([
            'status' => 'dibayar'
        ]);


        // update status dll payment

        $paymentMethod = $message["payment_type"] . " - " . $message["bank"];

        $orderPayment = Payment::where('order_id', $order->id)->update([
            'payment_method' => $paymentMethod,
            'payment_status' => $message["transaction_status"],
            'payment_details' => $message["status_message"] . ' - ' . "Card " . $message["masked_card"],
            'payment_date' => $message["transaction_time"]
        ]);
    }
}
