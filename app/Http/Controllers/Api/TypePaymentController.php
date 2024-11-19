<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypePaymentRequest;
use App\Models\TypePayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypePaymentController extends Controller
{
    /**
     * Display a listing of the type payments.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $typePayments = TypePayment::all();
        return response()->json($typePayments, 200);
    }

    /**
     * Store a newly created type payment in storage.
     *
     * @param TypePaymentRequest $request
     * @return JsonResponse
     */
    public function store(TypePaymentRequest $request): JsonResponse
    {
        $typePayment = TypePayment::create($request->validated());
        return response()->json($typePayment, 201);
    }

    /**
     * Display the specified type payment.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $typePayment = TypePayment::findOrFail($id);
        return response()->json($typePayment, 200);
    }

    /**
     * Update the specified type payment in storage.
     *
     * @param TypePaymentRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TypePaymentRequest $request, int $id): JsonResponse
    {
        $typePayment = TypePayment::findOrFail($id);
        $typePayment->update($request->validated());
        return response()->json($typePayment, 200);
    }

    /**
     * Remove the specified type payment from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $typePayment = TypePayment::findOrFail($id);
        $typePayment->delete();
        return response()->json(['message' => 'TypePayment deleted successfully'], 200);
    }
}
