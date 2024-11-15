<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Company;
use App\Models\Order;
use App\Models\OrderLine;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     *
     * @param string $company_id The ID of the company.
     * @return JsonResponse The JSON response containing the list of orders.
     */
    public function index(string $company_id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $orders = $company->orders->load(['orderLines']);
            return response()->json($orders, 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Store a newly created order in storage.
     *
     * @param string $company_id The ID of the company.
     * @param OrderRequest $request The request object containing the order data.
     * @return JsonResponse The JSON response containing the created order.
     */
    public function store(string $company_id, OrderRequest $request): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $order = Order::create($request->all());

            foreach ($request->input('order_lines', []) as $line) {
                OrderLine::create($line);
            }

            return response()->json($order->load(['orderLines']), 201);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Display the specified order.
     *
     * @param string $company_id The ID of the company.
     * @param string $id The ID of the order.
     * @return JsonResponse The JSON response containing the order.
     */
    public function show(string $company_id, string $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $order = Order::findOrFail($id);

            return response()->json($order->load(['orderLines']), 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Update the specified order in storage.
     *
     * @param string $company_id The ID of the company.
     * @param OrderRequest $request The request object containing the updated order data.
     * @param string $id The ID of the order.
     * @return JsonResponse The JSON response containing the updated order.
     */
    public function update(string $company_id, OrderRequest $request, string $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $order = Order::findOrFail($id);
            $order->update($request->all());

            $order->orderLines()->delete();
            foreach ($request->input('order_lines', []) as $line) {
                OrderLine::create($line);
            }

            return response()->json($order->load(['orderLines']), 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Remove the specified order from storage.
     *
     * @param string $company_id The ID of the company.
     * @param string $id The ID of the order.
     * @return JsonResponse The JSON response confirming the deletion.
     */
    public function destroy(string $company_id, string $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $order = Order::findOrFail($id);
            $order->orderLines()->delete();
            $order->delete();

            return response()->json(["message" => "Order With Id: {$id} Has Been Deleted"], 200);
        }
        return response()->json(['message' => 'You dont have access this Company'], 403);
    }
}
