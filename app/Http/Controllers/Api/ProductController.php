<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @param string $company_id The ID of the company.
     * @return JsonResponse The JSON response containing the list of products.
     */
    public function index(string $company_id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $products = $company->products->load(['productPrices', 'productCategory', 'supplier', 'purchase']);
            return response()->json($products, 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param string $company_id The ID of the company.
     * @param ProductRequest $request The request object containing the product data.
     * @return JsonResponse The JSON response containing the created product.
     */
    public function store(string $company_id, ProductRequest $request): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $product = Product::create($request->all());

            $product_price = $request->input('product_prices', []);
            foreach ($product_price as $price) {
                $product->productPrices()->create($price);
            }

            return response()->json($product->load(['productPrices']), 201);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Display the specified product.
     *
     * @param string $company_id The ID of the company.
     * @param string $id The ID of the product.
     * @return JsonResponse The JSON response containing the product.
     */
    public function show(string $company_id, string $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $product = Product::findOrFail($id);

            return response()->json($product->load(['productPrices', 'productCategory', 'supplier', 'purchase']), 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Update the specified product in storage.
     *
     * @param string $company_id The ID of the company.
     * @param ProductRequest $request The request object containing the updated product data.
     * @param string $id The ID of the product.
     * @return JsonResponse The JSON response containing the updated product.
     */
    public function update(string $company_id, ProductRequest $request, string $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $product = Product::findOrFail($id);
            $product->update($request->all());

            $product->productPrices()->delete();

            $product_price = $request->input('product_prices', []);
            foreach ($product_price as $price) {
                $product->productPrices()->create($price);
            }

            return response()->json($product->load(['productPrices', 'productCategory', 'supplier', 'purchase']), 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param string $company_id The ID of the company.
     * @param string $id The ID of the product.
     * @return JsonResponse The JSON response confirming the deletion.
     */
    public function destroy(string $company_id, string $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $product = Product::findOrFail($id);
            $product->productPrices()->delete();
            $product->delete();

            return response()->json(["message" => "Product With Id: {$id} Has Been Deleted"], 200);
        }
        return response()->json(['message' => 'You dont have access this Company'], 403);
    }
}
