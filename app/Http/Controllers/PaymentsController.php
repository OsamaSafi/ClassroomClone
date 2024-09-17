<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PaymentsController extends Controller
{
    public function create(Subscription $subscription)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $subscription->plan->name,
                    ],
                    'unit_amount' => $subscription->plan->price * 100,
                ],
                'quantity' => $subscription->expires_at->diffInMonths($subscription->created_at)
            ]],
            'client_reference_id' => $subscription->id,
            'metadata' => [
                'subscription_id' => $subscription->id
            ],
            'mode' => 'payment',
            'success_url' => route('payments.success', $subscription->id),
            'cancel_url' => route('payments.cancel', $subscription->id),
        ]);

        Payment::create([
            'user_id' => Auth::id(),
            'subscription_id' => $subscription->id,
            'amount' => $subscription->price,
            'currancy_code' => 'usd',
            'payment_gateway' => 'stripe',
            'gateway_reference_id' => $checkout_session->payment_intent,
            'data' => $checkout_session
        ]);
        return redirect()->away($checkout_session->url);
    }

    public function store(Request $request)
    {
        $subscription = Subscription::findOrFail($request->subscription_id);

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
        try {
            // Create a PaymentIntent with amount and currency
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $subscription->price * 100,
                'currency' => 'usd',
                // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return [
                'clientSecret' => $paymentIntent->client_secret,
            ];
        } catch (Error $e) {
            return Response::json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function success(Request $request, Subscription $subscription)
    {
        return view('payment.success');
    }
    public function cancel(Request $request, Subscription $subscription)
    {
        return view('payment.cancel');
    }
}
