<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecurringInvoiceRequest;
use App\Models\RecurringInvoice;
use Illuminate\Http\JsonResponse;

/**
 * Class RecurringInvoiceController
 *
 * Controller for handling recurring invoice-related operations.
 */
class RecurringInvoiceController extends Controller
{
    /**
     * Display a listing of the recurring invoices.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $recurringInvoices = RecurringInvoice::with(['lines'])->get();
        return response()->json($recurringInvoices, 200);
    }

    /**
     * Store a newly created recurring invoice in storage.
     *
     * @param RecurringInvoiceRequest $request The request object containing recurring invoice data.
     * @return JsonResponse
     */
    public function store(RecurringInvoiceRequest $request): JsonResponse
    {
        $recurringInvoice = RecurringInvoice::create($request->all());

        $lines = $request->input('lines', []);
        foreach ($lines as $line) {
            $recurringInvoice->lines()->create($line);
        }

        return response()->json($recurringInvoice->load(['lines']), 201);
    }

    /**
     * Display the specified recurring invoice.
     *
     * @param string $id The ID of the recurring invoice.
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $recurringInvoice = RecurringInvoice::with(['lines'])->findOrFail($id);
        return response()->json($recurringInvoice, 200);
    }

    /**
     * Update the specified recurring invoice in storage.
     *
     * @param RecurringInvoiceRequest $request The request object containing updated recurring invoice data.
     * @param string $id The ID of the recurring invoice.
     * @return JsonResponse
     */
    public function update(RecurringInvoiceRequest $request, string $id): JsonResponse
    {
        $recurringInvoice = RecurringInvoice::findOrFail($id);
        $recurringInvoice->update($request->all());

        $recurringInvoice->lines()->delete();
        foreach ($request->input('lines', []) as $line) {
            $recurringInvoice->lines()->create($line);
        }

        return response()->json($recurringInvoice->load(['lines']), 200);
    }

    /**
     * Remove the specified recurring invoice from storage.
     *
     * @param string $id The ID of the recurring invoice.
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $recurringInvoice = RecurringInvoice::findOrFail($id);
        $recurringInvoice->lines()->delete();
        $recurringInvoice->delete();

        return response()->json(["message" => "Recurring Invoice With Id: {$id} Has Been Deleted"], 200);
    }
}