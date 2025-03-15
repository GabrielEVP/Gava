<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $Categories = Category::all();
        return response()->json($Categories, 200);
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        $Category = Category::create($request->all());

        return response()->json($Category, 200);
    }

    public function show(string $id): JsonResponse
    {
        $Category = Category::findOrFail($id);
        return response()->json($Category, 200);
    }

    public function update(CategoryRequest $request, string $id): JsonResponse
    {
        $Category = Category::findOrFail($id);
        $Category->update($request->all());

        return response()->json($Category, 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $Category = Category::findOrFail($id);
        $Category->delete();

        return response()->json(["message" => "Category With Id: {$id} Has Been Deleted"], 200);
    }
}
