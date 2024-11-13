<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use App\Models\Company;
use App\Models\PurchaseLine;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the purchases for a specific company.
     *
     * @param int $company_id The ID of the company.
     * @return JsonResponse
     */
    public function index(int $company_id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $purchases = Purchase::where('company_id', $company_id)->get();
            return response()->json($purchases->load('purchaseLines'), 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Store a newly created purchase in storage.
     *
     * @param int $company_id
     * @param PurchaseRequest $request
     * @return JsonResponse
     */
    public function store(int $company_id, PurchaseRequest $request): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $purchase = Purchase::create($request->validated());

            foreach ($request->input('purchase_lines', []) as $line) {
                $line['purchase_id'] = $purchase->id;
                PurchaseLine::create($line);
            }
            return response()->json($purchase->load('purchaseLines'), 201);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Display the specified purchase.
     *
     * @param int $company_id The ID of the company.
     * @param int $id The ID of the purchase.
     * @return JsonResponse
     */
    public function show(int $company_id, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $purchase = Purchase::where('company_id', $company_id)->findOrFail($id);
            return response()->json($purchase, 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Update the specified purchase in storage.
     *
     * @param PurchaseRequest $request
     * @param int $company_id The ID of the company.
     * @param int $id The ID of the purchase.
     * @return JsonResponse
     */
    public function update(int $company_id, PurchaseRequest $request,  int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $purchase = Purchase::where('company_id', $company_id)->findOrFail($id);
            $purchase->update($request->all());

            $purchase->purchaseLines()->delete();

            foreach ($request->input('purchase_lines', []) as $line) {
                $line['purchase_id'] = $purchase->id;
                PurchaseLine::create($line);
            }

            return response()->json($purchase->load('purchaseLines'), 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Remove the specified purchase from storage.
     *
     * @param int $company_id The ID of the company.
     * @param int $id The ID of the purchase.
     * @return JsonResponse
     */
    public function destroy(int $company_id, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $purchase = Purchase::where('company_id', $company_id)->findOrFail($id);
            $purchase->delete();
            return response()->json(["message" => "purchase With Id: {$id} Has Been Deleted"], 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }
}
