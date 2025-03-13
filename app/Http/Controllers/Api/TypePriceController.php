<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypePriceRequest;
use App\Models\TypePrice;
use Illuminate\Http\JsonResponse;

class TypePriceController extends Controller
{
    public function index(): JsonResponse
    {
        $typePrices = TypePrice::all();
        return response()->json($typePrices, 200);
    }

    public function store(TypePriceRequest $request): JsonResponse
    {
        $typePrice = TypePrice::create($request->all());

        return response()->json($typePrice, 201);
    }

    public function show(string $id): JsonResponse
    {
        $typePrice = TypePrice::findOrFail($id);
        return response()->json($typePrice, 200);
    }

    public function update(TypePriceRequest $request, string $id): JsonResponse
    {
        $typePrice = TypePrice::findOrFail($id);
        $typePrice->update($request->all());

        return response()->json($typePrice, 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $typePrice = TypePrice::findOrFail($id);
        $typePrice->delete();

        return response()->json(["message" => "Type Price With Id: {$id} Has Been Deleted"], 200);
    }
}
