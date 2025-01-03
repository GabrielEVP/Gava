<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;

/**
 * Class SupplierController
 *
 * Controller for handling supplier-related operations.
 */
class SupplierController extends Controller
{
    /**
     * Display a listing of the suppliers.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers, 200);
    }

    /**
     * Store a newly created supplier in storage.
     *
     * @param SupplierRequest $request The request object containing supplier data.
     * @return JsonResponse
     */
    public function store(SupplierRequest $request): JsonResponse
    {
        $supplier = Supplier::create($request->all());

        $phones = $request->input('phones', []);
        foreach ($phones as $phone) {
            $supplier->phones()->create($phone);
        }

        $emails = $request->input('emails', []);
        foreach ($emails as $email) {
            $supplier->emails()->create($email);
        }

        $bankAccounts = $request->input('bank_accounts', []);
        foreach ($bankAccounts as $bankAccount) {
            $supplier->bankAccounts()->create($bankAccount);
        }

        return response()->json($supplier->load(['phones', 'emails', 'bankAccounts']), 201);
    }

    /**
     * Display the specified supplier.
     *
     * @param string $id The ID of the supplier.
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $supplier = Supplier::with(['phones', 'emails', 'bankAccounts'])->findOrFail($id);
        return response()->json($supplier, 200);
    }

    /**
     * Update the specified supplier in storage.
     *
     * @param SupplierRequest $request The request object containing updated supplier data.
     * @param string $id The ID of the supplier.
     * @return JsonResponse
     */
    public function update(SupplierRequest $request, string $id): JsonResponse
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        $supplier->phones()->delete();
        foreach ($request->input('phones', []) as $phone) {
            $supplier->phones()->create($phone);
        }

        $supplier->emails()->delete();
        foreach ($request->input('emails', []) as $email) {
            $supplier->emails()->create($email);
        }

        $supplier->bankAccounts()->delete();
        foreach ($request->input('bank_accounts', []) as $bankAccount) {
            $supplier->bankAccounts()->create($bankAccount);
        }

        return response()->json($supplier->load(['phones', 'emails', 'bankAccounts']), 200);
    }

    /**
     * Remove the specified supplier from storage.
     *
     * @param string $id The ID of the supplier.
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->phones()->delete();
        $supplier->emails()->delete();
        $supplier->bankAccounts()->delete();
        $supplier->delete();

        return response()->json(["message" => "Supplier With Id: {$id} Has Been Deleted"], 200);
    }
}