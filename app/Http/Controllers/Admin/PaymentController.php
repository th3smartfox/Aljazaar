<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user', 'order')->latest()->get();
        return view('dynamic_content.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load('user', 'order.items');
        return view('dynamic_content.payments.show', compact('payment'));
    }
}