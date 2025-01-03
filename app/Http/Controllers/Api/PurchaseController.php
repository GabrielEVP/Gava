<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use Illuminate\Http\JsonResponse;

/**
 * Class PurchaseController
 *
 * Controller for handling purchase-related operations.
 */
class PurchaseController extends Controller
{
    /**
     * Display a listing of the purchases.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $purchases = Purchase::with(['lines', 'payments', 'dueDates'])->get();
        return response()->json($purchases, 200);
    }

    /**
     * Store a newly created purchase in storage.
     *
     * @param PurchaseRequest $request The request object containing purchase data.
     * @return JsonResponse
     */
    public function store(PurchaseRequest $request): JsonResponse
    {
        $purchase = Purchase::create($request->all());

        $lines = $request->input('lines', []);
        foreach ($lines as $line) {
            $purchase->lines()->create($line);
        }

        $payments = $request->input('payments', []);
        foreach ($payments as $payment) {
            $purchase->payments()->create($payment);
        }

        $dueDates = $request->input('due_dates', []);
        foreach ($dueDates as $dueDate) {
            $purchase->dueDates()->create($dueDate);
        }

        return response()->json($purchase->load(['lines', 'payments', 'dueDates']), 201);
    }

    /**
     * Display the specified purchase.
     *
     * @param string $id The ID of the purchase.
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $purchase = Purchase::with(['lines', 'payments', 'dueDates'])->findOrFail($id);
        return response()->json($purchase, 200);
    }

    /**
     * Update the specified purchase in storage.
     *
     * @param PurchaseRequest $request The request object containing updated purchase data.
     * @param string $id The ID of the purchase.
     * @return JsonResponse
     */
    public function update(PurchaseRequest $request, string $id): JsonResponse
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->update($request->all());

        $purchase->lines()->delete();
        foreach ($request->input('lines', []) as $line) {
            $purchase->lines()->create($line);
        }

        $purchase->payments()->delete();
        foreach ($request->input('payments', []) as $payment) {
            $purchase->payments()->create($payment);
        }

        $purchase->dueDates()->delete();
        foreach ($request->input('due_dates', []) as $dueDate) {
            $purchase->dueDates()->create($dueDate);
        }

        return response()->json($purchase->load(['lines', 'payments', 'dueDates']), 200);
    }

    /**
     * Remove the specified purchase from storage.
     *
     * @param string $id The ID of the purchase.
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->lines()->delete();
        $purchase->payments()->delete();
        $purchase->dueDates()->delete();
        $purchase->delete();

        return response()->json(["message" => "Purchase With Id: {$id} Has Been Deleted"], 200);
    }
}