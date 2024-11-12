<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypePriceRequest;
use App\Models\Company;
use App\Models\TypePrice;
use Illuminate\Http\JsonResponse;

class TypePriceController extends Controller
{
    /**
     * Display a listing of the type prices.
     *
     * @param int $company_id
     * @return JsonResponse
     */
    public function index(int $company_id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $typePrices = $company->typePrices;
            return response()->json($typePrices, 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Store a newly created type price in storage.
     *
     * @param TypePriceRequest $request
     * @return JsonResponse
     */
    public function store(TypePriceRequest $request): JsonResponse
    {
        $company = Company::findOrFail($request->company_id);

        if (auth()->user()->can('access', $company)) {
            $typePrice = TypePrice::create($request->all());
            return response()->json($typePrice, 201);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Display the specified type price.
     *
     * @param int $company_id
     * @param TypePrice $typePrice
     * @return JsonResponse
     */
    public function show(int $company_id, TypePrice $typePrice): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            return response()->json($typePrice);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Update the specified type price in storage.
     *
     * @param TypePriceRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $company_id, TypePriceRequest $request, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $typePrice = TypePrice::findOrFail($id);
            $typePrice->update($request->all());


            return response()->json($typePrice, 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Remove the specified type price from storage.
     *
     * @param int $company_id
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $company_id, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $typePrice = typePrice::findOrFail($id);
            $typePrice->delete();

            return response()->json(["message" => "TypePrices With Id: {$id} Has Been Deleted"], 200);
        }
        return response()->json(['message' => 'You dont have access this Company'], 403);
    }
}
