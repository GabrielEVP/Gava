<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\ProductCategoryRequest;
use App\Models\Company;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the product categories.
     *
     * @param int $company_id The ID of the company.
     * @return JsonResponse The JSON response containing the list of product categories.
     */
    public function index(int $company_id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $categories = $company->productCategories;
            return response()->json($categories, 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Store a newly created product category in storage.
     *
     * @param int $company_id The ID of the company.
     * @param ProductCategoryRequest $request The request object containing the product category data.
     * @return JsonResponse The JSON response containing the created product category.
     */
    public function store(int $company_id, ProductCategoryRequest $request): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $category = ProductCategory::create($request->all());
            return response()->json($category, 201);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Display the specified product category.
     *
     * @param int $company_id The ID of the company.
     * @param int $id The ID of the product category.
     * @return JsonResponse The JSON response containing the product category.
     */
    public function show(int $company_id, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $category = ProductCategory::findOrFail($id);
            return response()->json($category, 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Update the specified product category in storage.
     *
     * @param int $company_id The ID of the company.
     * @param ProductCategoryRequest $request The request object containing the updated product category data.
     * @param int $id The ID of the product category.
     * @return JsonResponse The JSON response containing the updated product category.
     */
    public function update(int $company_id, ProductCategoryRequest $request, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $category = ProductCategory::findOrFail($id);
            $category->update($request->all());
            return response()->json($category, 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Remove the specified product category from storage.
     *
     * @param int $company_id The ID of the company.
     * @param int $id The ID of the product category.
     * @return JsonResponse The JSON response confirming the deletion.
     */
    public function destroy(int $company_id, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $category = ProductCategory::findOrFail($id);
            $category->delete();
            return response()->json(["message" => "ProductCategory With Id: {$id} Has Been Deleted"], 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }
}
