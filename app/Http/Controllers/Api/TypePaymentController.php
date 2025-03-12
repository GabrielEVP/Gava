<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypePaymentRequest;
use App\Models\TypePayment;
use Illuminate\Http\JsonResponse;

class TypePaymentController extends Controller
{
    public function index(): JsonResponse
    {
        $typePayments = TypePayment::all();
        return response()->json($typePayments, 200);
    }

    public function store(TypePaymentRequest $request): JsonResponse
    {
        $typePayment = TypePayment::create($request->all());

        return response()->json($typePayment, 201);
    }

    public function show(string $id): JsonResponse
    {
        $typePayment = TypePayment::findOrFail($id);
        return response()->json($typePayment, 200);
    }

    public function update(TypePaymentRequest $request, string $id): JsonResponse
    {
        $typePayment = TypePayment::findOrFail($id);
        $typePayment->update($request->all());

        return response()->json($typePayment, 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $typePayment = TypePayment::findOrFail($id);
        $typePayment->delete();

        return response()->json(["message" => "Type Payment With Id: {$id} Has Been Deleted"], 200);
    }
}
