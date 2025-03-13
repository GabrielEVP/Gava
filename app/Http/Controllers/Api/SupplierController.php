<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    public function index(): JsonResponse
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers, 200);
    }

    public function store(SupplierRequest $request): JsonResponse
    {
        $supplier = Supplier::create($request->all());

        $addresses = $request->input('addresses', []);
        foreach ($addresses as $address) {
            $supplier->addresses()->create($address);
        }

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

        return response()->json($supplier->load(['phones', 'emails', 'bankAccounts']), 200);
    }

    public function show(string $id): JsonResponse
    {
        $supplier = Supplier::with(['phones', 'emails', 'bankAccounts'])->findOrFail($id);
        return response()->json($supplier, 200);
    }

    public function update(SupplierRequest $request, string $id): JsonResponse
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        $supplier->addresses->delete();
        foreach ($request->input('addresses', []) as $address) {
            $supplier->addresses()->create($address);
        }

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

    public function destroy(string $id): JsonResponse
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->addresses()->delete();
        $supplier->phones()->delete();
        $supplier->emails()->delete();
        $supplier->bankAccounts()->delete();
        $supplier->delete();

        return response()->json(["message" => "Supplier With Id: {$id} Has Been Deleted"], 200);
    }

    public function search(string $query): JsonResponse
    {
        $suppliers = Supplier::with(['phones', 'emails', 'bankAccounts'])
            ->where('legal_name', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($suppliers, 200);
    }
}
