<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecurringInvoiceRequest;
use App\Models\RecurringInvoice;
use App\Models\RecurringInvoiceLine;
use App\Models\Company;
use Illuminate\Http\JsonResponse;

class RecurringInvoiceController extends Controller
{
    /**
     * Display a listing of the recurring invoices.
     *
     * @param string $company_id The ID of the company.
     * @return JsonResponse The JSON response containing the list of recurring invoices.
     */
    public function index(string $company_id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $recurringInvoices = $company->recurringInvoices->load('lines');
            return response()->json($recurringInvoices, 200);
        }

        return response()->json(['message' => 'You don\'t have access to this Company'], 403);
    }

    /**
     * Store a newly created recurring invoice in storage.
     *
     * @param string $company_id The ID of the company.
     * @param RecurringInvoiceRequest $request The request object containing the recurring invoice data.
     * @return JsonResponse The JSON response containing the created recurring invoice.
     */
    public function store(string $company_id, RecurringInvoiceRequest $request): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $recurringInvoice = RecurringInvoice::create($request->validated());

            foreach ($request->input('lines', []) as $line) {
                $line['recurring_invoice_id'] = $recurringInvoice->id;
                RecurringInvoiceLine::create($line);
            }

            return response()->json($recurringInvoice->load('lines'), 201);
        }

        return response()->json(['message' => 'You don\'t have access to this Company'], 403);
    }

    /**
     * Display the specified recurring invoice.
     *
     * @param string $company_id The ID of the company.
     * @param int $id The ID of the recurring invoice.
     * @return JsonResponse The JSON response containing the recurring invoice.
     */
    public function show(string $company_id, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $recurringInvoice = RecurringInvoice::with('lines')->findOrFail($id);
            return response()->json($recurringInvoice, 200);
        }

        return response()->json(['message' => 'You don\'t have access to this Company'], 403);
    }

    /**
     * Update the specified recurring invoice in storage.
     *
     * @param string $company_id The ID of the company.
     * @param RecurringInvoiceRequest $request The request object containing the updated recurring invoice data.
     * @param int $id The ID of the recurring invoice.
     * @return JsonResponse The JSON response containing the updated recurring invoice.
     */
    public function update(string $company_id, RecurringInvoiceRequest $request, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $recurringInvoice = RecurringInvoice::findOrFail($id);
            $recurringInvoice->update($request->validated());

            $recurringInvoice->lines()->delete();
            foreach ($request->input('lines', []) as $line) {
                $line['recurring_invoice_id'] = $recurringInvoice->id;
                RecurringInvoiceLine::create($line);
            }

            return response()->json($recurringInvoice->load('lines'), 200);
        }

        return response()->json(['message' => 'You don\'t have access to this Company'], 403);
    }

    /**
     * Remove the specified recurring invoice from storage.
     *
     * @param string $company_id The ID of the company.
     * @param int $id The ID of the recurring invoice.
     * @return JsonResponse The JSON response confirming the deletion.
     */
    public function destroy(string $company_id, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $recurringInvoice = RecurringInvoice::findOrFail($id);
            $recurringInvoice->lines()->delete();
            $recurringInvoice->delete();

            return response()->json(['message' => 'RecurringInvoice deleted successfully'], 200);
        }

        return response()->json(['message' => 'You don\'t have access to this Company'], 403);
    }
}
