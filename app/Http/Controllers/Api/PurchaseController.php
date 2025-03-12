<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{
    public function index(): JsonResponse
    {
        $purchases = Purchase::with(['lines', 'payments', 'dueDates'])->get();
        return response()->json($purchases, 200);
    }

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

    public function show(string $id): JsonResponse
    {
        $purchase = Purchase::with(['lines', 'payments', 'dueDates'])->findOrFail($id);
        return response()->json($purchase, 200);
    }

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
