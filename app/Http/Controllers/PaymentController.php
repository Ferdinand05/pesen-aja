<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResources;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\TryCatch;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->startDate || $request->endDate) {
            $payments = Payment::whereDate('created_at', $request->startDate)->orWhereDate('created_at', $request->endDate)->orderBy('payment_date', 'desc')->paginate(6)->withQueryString();
        } elseif ($request->startDate && $request->endDate) {
            $payments = Payment::whereDate('created_at', '>=', $request->startDate)->WhereDate('created_at', '<=', $request->endDate)->orderBy('payment_date', 'desc')->paginate(6)->withQueryString();
        } else {
            $payments = Payment::orderBy('payment_date', 'desc')->paginate(6);
        }

        return Inertia::render('Payment/PaymentView', ['payments' => PaymentResources::collection($payments)]);
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
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
