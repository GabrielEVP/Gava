<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        $orders = Order::with(['lines'])->get();
        return response()->json($orders, 200);
    }

    public function store(OrderRequest $request): JsonResponse
    {
        $order = Order::create($request->all());

        $lines = $request->input('lines', []);
        foreach ($lines as $line) {
            $order->lines()->create($line);
        }

        return response()->json($order->load(['lines']), 200);
    }

    public function show(string $id): JsonResponse
    {
        $order = Order::with(['lines'])->findOrFail($id);
        return response()->json($order, 200);
    }

    public function update(OrderRequest $request, string $id): JsonResponse
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());

        $order->lines()->delete();
        foreach ($request->input('lines', []) as $line) {
            $order->lines()->create($line);
        }

        return response()->json($order->load(['lines']), 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $order = Order::findOrFail($id);
        $order->lines()->delete();
        $order->delete();

        return response()->json(["message" => "Order With Id: {$id} Has Been Deleted"], 200);
    }
}
