<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Company;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    /**
     * Display a listing of the suppliers.
     *
     * @param int $company_id The ID of the company.
     * @return JsonResponse The JSON response containing the list of suppliers.
     */
    public function index(int $company_id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $suppliers = $company->suppliers;
            return response()->json($suppliers, 200);
        }

        return response()->json(['message' => 'You dont have access to this Company'], 403);
    }

    /**
     * Store a newly created supplier in storage.
     *
     * @param int $company_id The ID of the company.
     * @param SupplierRequest $request The request object containing the supplier data.
     * @return JsonResponse The JSON response containing the created supplier.
     */
    public function store(int $company_id, SupplierRequest $request): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $supplier = Supplier::create($request->all());
            return response()->json($supplier, 201);
        }

        return response()->json(['message' => 'You dont have access to this Company'], 403);
    }

    /**
     * Display the specified supplier.
     *
     * @param int $company_id The ID of the company.
     * @param int $id The ID of the supplier.
     * @return JsonResponse The JSON response containing the supplier.
     */
    public function show(int $company_id, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $supplier = Supplier::findOrFail($id);
            return response()->json($supplier, 200);
        }

        return response()->json(['message' => 'You dont have access to this Company'], 403);
    }

    /**
     * Update the specified supplier in storage.
     *
     * @param int $company_id The ID of the company.
     * @param SupplierRequest $request The request object containing the updated supplier data.
     * @param int $id The ID of the supplier.
     * @return JsonResponse The JSON response containing the updated supplier.
     */
    public function update(int $company_id, SupplierRequest $request, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $supplier = Supplier::findOrFail($id);
            $supplier->update($request->all());
            return response()->json($supplier, 200);
        }

        return response()->json(['message' => 'You dont have access to this Company'], 403);
    }

    /**
     * Remove the specified supplier from storage.
     *
     * @param int $company_id The ID of the company.
     * @param int $id The ID of the supplier.
     * @return JsonResponse The JSON response confirming the deletion.
     */
    public function destroy(int $company_id, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();
            return response()->json(["message" => "Supplier With Id: {$id} Has Been Deleted"], 200);
        }

        return response()->json(['message' => 'You dont have access to this Company'], 403);
    }
}
