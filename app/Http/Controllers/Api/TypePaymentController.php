<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypePaymentRequest;
use App\Models\TypePayment;
use Illuminate\Http\JsonResponse;

/**
 * Class TypePaymentController
 *
 * Controller for handling type payment-related operations.
 */
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
     * @param TypePaymentRequest $request The request object containing type payment data.
     * @return JsonResponse
     */
    public function store(TypePaymentRequest $request): JsonResponse
    {
        $typePayment = TypePayment::create($request->all());

        return response()->json($typePayment, 201);
    }

    /**
     * Display the specified type payment.
     *
     * @param string $id The ID of the type payment.
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $typePayment = TypePayment::findOrFail($id);
        return response()->json($typePayment, 200);
    }

    /**
     * Update the specified type payment in storage.
     *
     * @param TypePaymentRequest $request The request object containing updated type payment data.
     * @param string $id The ID of the type payment.
     * @return JsonResponse
     */
    public function update(TypePaymentRequest $request, string $id): JsonResponse
    {
        $typePayment = TypePayment::findOrFail($id);
        $typePayment->update($request->all());

        return response()->json($typePayment, 200);
    }

    /**
     * Remove the specified type payment from storage.
     *
     * @param string $id The ID of the type payment.
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $typePayment = TypePayment::findOrFail($id);
        $typePayment->delete();

        return response()->json(["message" => "Type Payment With Id: {$id} Has Been Deleted"], 200);
    }
}