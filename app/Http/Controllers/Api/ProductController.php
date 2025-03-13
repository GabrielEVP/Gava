<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::with(['category', 'supplier', 'purchase', 'prices'])->get();
        return response()->json($products, 200);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = Product::create($request->all());

        $prices = $request->input('prices', []);
        foreach ($prices as $price) {
            $product->prices()->create($price);
        }

        return response()->json($product->load(['category', 'supplier', 'purchase', 'prices']), 201);
    }

    public function show(string $id): JsonResponse
    {
        $product = Product::with(['category', 'supplier', 'purchase', 'prices'])->findOrFail($id);
        return response()->json($product, 200);
    }

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

    public function destroy(string $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->prices()->delete();
        $product->delete();

        return response()->json(["message" => "Product With Id: {$id} Has Been Deleted"], 200);
    }
}
