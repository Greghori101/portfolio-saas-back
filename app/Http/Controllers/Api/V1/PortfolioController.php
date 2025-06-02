<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortfolioRequest;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(Portfolio::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePortfolioRequest $request)
    {
        //
        $portfolio = Portfolio::create($request->validated());
        return response()->json($portfolio, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $portfolio = Portfolio::findOrFail($id);
        return response()->json($portfolio->load(['theme', 'user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePortfolioRequest $request, string $id)
    {
        //
        $portfolio = Portfolio::findOrFail($id);
        $portfolio->update($request->validated());
        return response()->json($portfolio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $portfolio = Portfolio::findOrFail($id);
        $portfolio->delete();
        return response()->noContent();
    }
}
