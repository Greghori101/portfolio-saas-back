<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Consumption;
use App\Models\Subscription;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ConsumptionController extends Controller
{
    public function index()
    {
        $consumptions = Consumption::with(['subscription.user', 'feature'])->get();
        return response()->json($consumptions);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subscription_id' => ['required', 'uuid', Rule::exists('subscriptions', 'id')],
            'feature_id' => ['required', 'uuid', Rule::exists('features', 'id')],
            'points' => ['required', 'integer', 'min:0'],
        ]);

        $existing = Consumption::where('subscription_id', $data['subscription_id'])
                               ->where('feature_id', $data['feature_id'])
                               ->first();

        if ($existing) {
            // Increment existing usage
            $existing->increment('points', $data['points']);
            return response()->json($existing->fresh()->load(['subscription.user', 'feature']));
        }

        // Create new consumption record
        $consumption = Consumption::create($data);
        return response()->json($consumption->load(['subscription.user', 'feature']), 201);
    }

    public function show(string $id)
    {
        $consumption = Consumption::with(['subscription.user', 'feature'])->findOrFail($id);
        return response()->json($consumption);
    }

    public function update(Request $request, string $id)
    {
        $consumption = Consumption::findOrFail($id);

        $data = $request->validate([
            'points' => ['required', 'integer', 'min:0'],
        ]);

        $consumption->update($data);

        return response()->json($consumption->load(['subscription.user', 'feature']));
    }

    public function destroy(string $id)
    {
        $consumption = Consumption::findOrFail($id);
        $consumption->delete();
        return response()->json(['message' => 'Consumption record deleted.']);
    }
}
