<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use App\Models\Product;
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

        return response()->json($purchase->load(['lines', 'payments', 'dueDates']), status: 200);
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

    public function paidPurchaseAndDeliveredProducts(string $id): JsonResponse
    {
        $purchase = Purchase::findOrFail($id);

        if ($purchase->status == 'paid') {
            return response()->json(["message" => "Purchase status is Paid"], 409);
        }

        $purchase->update(['status' => 'paid']);

        $lines = $purchase->lines;

        foreach ($lines as $line) {
            if ($line->status == 'delivered') {
                continue;
            }

            $product = null;

            if ($line->product_id) {
                $product = Product::find($line->product_id);
            }

            if (!$product) {
                $product = Product::create([
                    'name' => $line->description,
                    'description' => $line->description,
                    'purchase_price' => $line->unit_price,
                    'tax_rate' => $line->tax_rate,
                    'stock_quantity' => $line->quantity,
                    'user_id' => $purchase->user_id,
                ]);
                $line->update(['product_id' => $product->id]);
            } else {
                $stock = $product->stock_quantity + $line->quantity;
                $product->update(['stock_quantity' => $stock]);
            }
            $line->update(['status' => 'delivered']);
        }

        return response()->json(["message" => "Products attached (or created and attached) successfully"], 200);
    }
}
