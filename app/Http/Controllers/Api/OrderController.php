<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

/**
 * Class OrderController
 *
 * Controller for handling order-related operations.
 */
class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = Order::with(['lines'])->get();
        return response()->json($orders, 200);
    }

    /**
     * Store a newly created order in storage.
     *
     * @param OrderRequest $request The request object containing order data.
     * @return JsonResponse
     */
    public function store(OrderRequest $request): JsonResponse
    {
        $order = Order::create($request->all());

        $lines = $request->input('lines', []);
        foreach ($lines as $line) {
            $order->lines()->create($line);
        }

        return response()->json($order->load(['lines']), 201);
    }

    /**
     * Display the specified order.
     *
     * @param string $id The ID of the order.
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $order = Order::with(['lines'])->findOrFail($id);
        return response()->json($order, 200);
    }

    /**
     * Update the specified order in storage.
     *
     * @param OrderRequest $request The request object containing updated order data.
     * @param string $id The ID of the order.
     * @return JsonResponse
     */
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

    /**
     * Remove the specified order from storage.
     *
     * @param string $id The ID of the order.
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $order = Order::findOrFail($id);
        $order->lines()->delete();
        $order->delete();

        return response()->json(["message" => "Order With Id: {$id} Has Been Deleted"], 200);
    }
}