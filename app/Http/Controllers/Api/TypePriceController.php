<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypePriceRequest;
use App\Models\TypePrice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypePriceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search', '');
        $sort = $request->query('sort')['column'] ?? 'name';
        $order = strtolower($request->query('sort')['order'] ?? 'asc');

        $validColumns = ['id', 'name', 'type', 'margin'];

        if (!in_array($sort, $validColumns)) {
            return response()->json(['error' => 'Invalid sortBy column'], 400);
        }

        if (!in_array($order, ['asc', 'desc'])) {
            return response()->json(['error' => 'Invalid order value'], 400);
        }

        $query = TypePrice::query();

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        if ($request->has('select')) {
            foreach ($request->query('select') as $filter) {
                if (!empty($filter['option']) && !empty($filter['value']) && in_array($filter['option'], $validColumns)) {
                    $query->where($filter['option'], $filter['value']);
                }
            }
        }

        $query->orderBy($sort, $order);

        $typePrices = $query->get();

        return response()->json($typePrices, 200);
    }


    public function store(TypePriceRequest $request): JsonResponse
    {
        $typePrice = TypePrice::create($request->all());

        return response()->json($typePrice, 201);
    }

    public function show(string $id): JsonResponse
    {
        $typePrice = TypePrice::findOrFail($id);
        return response()->json($typePrice, 200);
    }

    public function update(TypePriceRequest $request, string $id): JsonResponse
    {
        $typePrice = TypePrice::findOrFail($id);
        $typePrice->update($request->all());

        return response()->json($typePrice, 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $typePrice = TypePrice::findOrFail($id);
        $typePrice->delete();

        return response()->json(["message" => "Type Price With Id: {$id} Has Been Deleted"], 200);
    }
}
