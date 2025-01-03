<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

/**
 * Class ProductController
 *
 * Controller for handling product-related operations.
 */
class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = Product::with(['category', 'supplier', 'purchase', 'prices'])->get();
        return response()->json($products, 200);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param ProductRequest $request The request object containing product data.
     * @return JsonResponse
     */
    public function store(ProductRequest $request): JsonResponse
    {
        $product = Product::create($request->all());

        $prices = $request->input('prices', []);
        foreach ($prices as $price) {
            $product->prices()->create($price);
        }

        return response()->json($product->load(['category', 'supplier', 'purchase', 'prices']), 201);
    }

    /**
     * Display the specified product.
     *
     * @param string $id The ID of the product.
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $product = Product::with(['category', 'supplier', 'purchase', 'prices'])->findOrFail($id);
        return response()->json($product, 200);
    }

    /**
     * Update the specified product in storage.
     *
     * @param ProductRequest $request The request object containing updated product data.
     * @param string $id The ID of the product.
     * @return JsonResponse
     */
    public function update(ProductRequest $request, string $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        $product->prices()->delete();
        foreach ($request->input('prices', []) as $price) {
            $product->prices()->create($price);
        }

        return response()->json($product->load(['category', 'supplier', 'purchase', 'prices']), 200);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param string $id The ID of the product.
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->prices()->delete();
        $product->delete();

        return response()->json(["message" => "Product With Id: {$id} Has Been Deleted"], 200);
    }
}