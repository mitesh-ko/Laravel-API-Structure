<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * This method is responsible to update or create a payment
     * and the payment gateway URL send in response
     * @return JsonResponse
     */
    public function initiate()
    {
        $cartTotal = Cart::where('user_id', Auth::id())->sum('total');
        $payment = Payment::updateOrCreate([
            'user_id'        => Auth::id(),
            'payment_status' => Payment::PENDING], [
            'payment_amount' => $cartTotal,
        ]);
        $payment->paymentUrl = 'A payment URL from payment gateway';

        return apiResponse(true, __('Make a payment.'), $payment);
    }

    /**
     * @param Request $request
     * @return void
     *
     * This method will call by payment gateway callback
     * To make sure user can't hit this URL to change payment status
     * a payment gateway id always matched if available
     * Once payment status updated from pending it can't change again
     */
    public function success(Request $request)
    {
        Payment::where('id', $request->payment_id)
            ->where('payment_status', Payment::PENDING)
            ->update([
            'payment_status' => Payment::SUCCESS
        ]);
    }

    /**
     * @param Request $request
     * @return void
     *
     * This method will call by payment gateway callback
     * To make sure user can't hit this URL to change payment status
     * a payment gateway id always matched if available
     * Once payment status updated from pending it can't change again
     */
    public function failed(Request $request)
    {
        Payment::where('id', $request->payment_id)
            ->where('payment_status', Payment::PENDING)
            ->update([
            'payment_status' => Payment::FAILED
        ]);
    }
}
