<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Subscription;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'plan'])->get();
        return response()->json($subscriptions);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'uuid', Rule::exists('users', 'id')],
            'plan_id' => ['required', 'uuid', Rule::exists('plans', 'id')],
            'status' => ['required', 'string'],
            'started_at' => ['required', 'date'],
            'expired_at' => ['required', 'date', 'after_or_equal:started_at'],
            'suppressed_at' => ['nullable', 'date'],
        ]);

        DB::beginTransaction();
        try {
            $subscription = Subscription::create($data);
            DB::commit();
            return response()->json($subscription->load(['user', 'plan']), 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        $subscription = Subscription::with(['user', 'plan'])->findOrFail($id);
        return response()->json($subscription);
    }

    public function update(Request $request, string $id)
    {
        $subscription = Subscription::findOrFail($id);

        $data = $request->validate([
            'plan_id' => ['sometimes', 'uuid', Rule::exists('plans', 'id')],
            'status' => ['sometimes', 'string'],
            'started_at' => ['sometimes', 'date'],
            'expired_at' => ['sometimes', 'date', 'after_or_equal:started_at'],
            'suppressed_at' => ['nullable', 'date'],
        ]);

        $subscription->update($data);

        return response()->json($subscription->load(['user', 'plan']));
    }

    public function destroy(string $id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();
        return response()->json(['message' => 'Subscription deleted successfully.']);
    }
}
