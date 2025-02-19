<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductCategory;
use App\Http\Requests\ProductCategoryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ProductCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = ProductCategory::all();
        return response()->json($categories);
    }

    public function store(ProductCategoryRequest $request): JsonResponse
    {
        $category = new ProductCategory();
        $category->create($request->all());
        return response()->json(['message' => 'Category added successfully!', 'category' => $category], 201);
    }

    public function show(string $id): JsonResponse
    {
        $category = ProductCategory::findOrFail($id);
        return response()->json($category);
    }

    public function update(ProductCategoryRequest $request, string $id): JsonResponse
    {
        $category = ProductCategory::findOrFail($id);
        $category->create($request->all());
        return response()->json(['message' => 'Category updated successfully!', 'category' => $category], 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $category = ProductCategory::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully!'], 200);
    }
}