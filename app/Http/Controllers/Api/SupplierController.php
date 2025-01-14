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
        $suppliers = Supplier::all(); // No filtra por company_id
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
        // Crea el proveedor sin la dependencia de una compañía
        $supplier = Supplier::create($request->all());

        // Crea los teléfonos, correos y cuentas bancarias relacionados con el proveedor
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
        // Muestra el proveedor junto con los teléfonos, correos y cuentas bancarias
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
        // Encuentra el proveedor por su ID
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        // Elimina los datos previos y agrega los nuevos
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
        // Encuentra y elimina el proveedor y sus relaciones
        $supplier = Supplier::findOrFail($id);
        $supplier->phones()->delete();
        $supplier->emails()->delete();
        $supplier->bankAccounts()->delete();
        $supplier->delete();

        return response()->json(["message" => "Supplier With Id: {$id} Has Been Deleted"], 200);
    }

    /**
     * Search for suppliers based on a query string.
     *
     * @param string $query The search query.
     * @return JsonResponse
     */
    public function search(string $query): JsonResponse
    {
        // Busca proveedores basados en el nombre legal
        $suppliers = Supplier::with(['phones', 'emails', 'bankAccounts'])
            ->where('legal_name', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($suppliers, 200);
    }
}
