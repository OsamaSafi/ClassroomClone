<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Throwable;

class SubscriptionsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => ['required', 'int'],
            'period' => ['required', 'int', 'min:1'],
        ]);
        $user = $request->user();
        $plan = Plan::findOrFail($request->post('plan_id'));
        $months = $request->post('period');
        try {
            $subscription = Subscription::create([
                'plan_id' => $plan->id,
                'user_id' => $user->id,
                'price' => $plan->price * $months,
                'expires_at' => now()->addMonth($months),
            ]);
            return redirect()->route('chackout', $subscription->id);
        } catch (Throwable $e) {
            return back()->with('danger', $e->getMessage());
        }

        return redirect()->route('classrooms.index')->with('success', "$user->name subscription !");
    }
}
