<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Plan;
use App\Models\Feature;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::with(['features', 'currency'])->get();
        return response()->json($plans);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'status' => ['required', 'string'],
            'type' => ['required', 'string'],
            'currency_id' => ['required', 'uuid', Rule::exists('currencies', 'id')],
            'features' => ['array'],
            'features.*.id' => ['required', 'uuid', Rule::exists('features', 'id')],
            'features.*.points' => ['nullable', 'integer'],
            'features.*.consumable' => ['nullable', 'boolean'],
        ]);

        DB::beginTransaction();
        try {
            $plan = Plan::create($data);

            // Attach currency
            $plan->currency()->attach($data['currency_id']);

            // Attach features
            if (!empty($data['features'])) {
                foreach ($data['features'] as $feature) {
                    $plan->features()->attach($feature['id'], [
                        'points' => $feature['points'] ?? null,
                        'consumable' => $feature['consumable'] ?? false,
                    ]);
                }
            }

            DB::commit();
            return response()->json($plan->load(['features', 'currency']), 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        $plan = Plan::with(['features', 'currency'])->findOrFail($id);
        return response()->json($plan);
    }

    public function update(Request $request, string $id)
    {
        $plan = Plan::findOrFail($id);

        $data = $request->validate([
            'name' => ['sometimes', 'string'],
            'price' => ['sometimes', 'numeric'],
            'status' => ['sometimes', 'string'],
            'type' => ['sometimes', 'string'],
            'currency_id' => ['sometimes', 'uuid', Rule::exists('currencies', 'id')],
            'features' => ['array'],
            'features.*.id' => ['required', 'uuid', Rule::exists('features', 'id')],
            'features.*.points' => ['nullable', 'integer'],
            'features.*.consumable' => ['nullable', 'boolean'],
        ]);

        DB::beginTransaction();
        try {
            $plan->update($data);

            if (isset($data['currency_id'])) {
                $plan->currency()->sync([$data['currency_id']]);
            }

            if (isset($data['features'])) {
                $syncData = [];
                foreach ($data['features'] as $feature) {
                    $syncData[$feature['id']] = [
                        'points' => $feature['points'] ?? null,
                        'consumable' => $feature['consumable'] ?? false,
                    ];
                }
                $plan->features()->sync($syncData);
            }

            DB::commit();
            return response()->json($plan->load(['features', 'currency']));

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return response()->json(['message' => 'Plan deleted successfully.']);
    }
}
