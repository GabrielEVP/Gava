<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierCategoryRequest;
use App\Models\Company;
use App\Models\SupplierCategory;
use Illuminate\Http\JsonResponse;

class SupplierCategoryController extends Controller
{
    /**
     * Display a listing of the supplier categories.
     *
     * @param int $company_id The ID of the company.
     * @return JsonResponse The JSON response containing the list of supplier categories.
     */
    public function index(int $company_id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $categories = $company->supplierCategories;
            return response()->json($categories, 200);
        }

        return response()->json(['message' => 'You dont have access to this Company'], 403);
    }

    /**
     * Store a newly created supplier category in storage.
     *
     * @param int $company_id The ID of the company.
     * @param SupplierCategoryRequest $request The request object containing the supplier category data.
     * @return JsonResponse The JSON response containing the created supplier category.
     */
    public function store(int $company_id, SupplierCategoryRequest $request): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $data = $request->all();
            $data['company_id'] = $company_id;
            $category = SupplierCategory::create($data);
            return response()->json($category, 201);
        }

        return response()->json(['message' => 'You dont have access to this Company'], 403);
    }

    /**
     * Display the specified supplier category.
     *
     * @param int $company_id The ID of the company.
     * @param int $id The ID of the supplier category.
     * @return JsonResponse The JSON response containing the supplier category.
     */
    public function show(int $company_id, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $category = SupplierCategory::findOrFail($id);
            return response()->json($category, 200);
        }

        return response()->json(['message' => 'You dont have access to this Company'], 403);
    }

    /**
     * Update the specified supplier category in storage.
     *
     * @param int $company_id The ID of the company.
     * @param SupplierCategoryRequest $request The request object containing the updated supplier category data.
     * @param int $id The ID of the supplier category.
     * @return JsonResponse The JSON response containing the updated supplier category.
     */
    public function update(int $company_id, SupplierCategoryRequest $request, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $category = SupplierCategory::findOrFail($id);
            $category->update($request->all());
            return response()->json($category, 200);
        }

        return response()->json(['message' => 'You dont have access to this Company'], 403);
    }

    /**
     * Remove the specified supplier category from storage.
     *
     * @param int $company_id The ID of the company.
     * @param int $id The ID of the supplier category.
     * @return JsonResponse The JSON response confirming the deletion.
     */
    public function destroy(int $company_id, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $category = SupplierCategory::findOrFail($id);
            $category->delete();
            return response()->json(["message" => "SupplierCategory With Id: {$id} Has Been Deleted"], 200);
        }

        return response()->json(['message' => 'You dont have access to this Company'], 403);
    }
}
