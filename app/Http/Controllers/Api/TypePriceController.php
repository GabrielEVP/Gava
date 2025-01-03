<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypePriceRequest;
use App\Models\TypePrice;
use Illuminate\Http\JsonResponse;

/**
 * Class TypePriceController
 *
 * Controller for handling type price-related operations.
 */
class TypePriceController extends Controller
{
    /**
     * Display a listing of the type prices.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $typePrices = TypePrice::all();
        return response()->json($typePrices, 200);
    }

    /**
     * Store a newly created type price in storage.
     *
     * @param TypePriceRequest $request The request object containing type price data.
     * @return JsonResponse
     */
    public function store(TypePriceRequest $request): JsonResponse
    {
        $typePrice = TypePrice::create($request->all());

        return response()->json($typePrice, 201);
    }

    /**
     * Display the specified type price.
     *
     * @param string $id The ID of the type price.
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $typePrice = TypePrice::findOrFail($id);
        return response()->json($typePrice, 200);
    }

    /**
     * Update the specified type price in storage.
     *
     * @param TypePriceRequest $request The request object containing updated type price data.
     * @param string $id The ID of the type price.
     * @return JsonResponse
     */
    public function update(TypePriceRequest $request, string $id): JsonResponse
    {
        $typePrice = TypePrice::findOrFail($id);
        $typePrice->update($request->all());

        return response()->json($typePrice, 200);
    }

    /**
     * Remove the specified type price from storage.
     *
     * @param string $id The ID of the type price.
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $typePrice = TypePrice::findOrFail($id);
        $typePrice->delete();

        return response()->json(["message" => "Type Price With Id: {$id} Has Been Deleted"], 200);
    }
}