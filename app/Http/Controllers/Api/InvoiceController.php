<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\InvoiceDueDate;
use App\Models\InvoicePayment;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     *
     * @param string $company_id The ID of the company.
     * @return JsonResponse The JSON response containing the list of invoices.
     */
    public function index(string $company_id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $invoices = $company->invoices->load(['lines', 'dueDates', 'payments']);
            return response()->json($invoices, 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Store a newly created invoice in storage.
     *
     * @param string $company_id The ID of the company.
     * @param InvoiceRequest $request The request object containing the invoice data.
     * @return JsonResponse The JSON response containing the created invoice.
     */
    public function store(string $company_id, InvoiceRequest $request): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $invoice = Invoice::create($request->all());

            foreach ($request->input('lines', []) as $line) {
                $line['invoice_id'] = $invoice->id;
                InvoiceLine::create($line);
            }

            foreach ($request->input('due_dates', []) as $dueDate) {
                $dueDate['invoice_id'] = $invoice->id;
                InvoiceDueDate::create($dueDate);
            }

            foreach ($request->input('payments', []) as $payment) {
                $payment['invoice_id'] = $invoice->id;
                InvoicePayment::create($payment);
            }

            return response()->json($invoice->load(['lines', 'dueDates', 'payments']), 201);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Display the specified invoice.
     *
     * @param string $company_id The ID of the company.
     * @param string $id The ID of the invoice.
     * @return JsonResponse The JSON response containing the invoice.
     */
    public function show(string $company_id, string $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $invoice = Invoice::findOrFail($id);

            return response()->json($invoice->load(['lines', 'dueDates', 'payments']), 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Update the specified invoice in storage.
     *
     * @param string $company_id The ID of the company.
     * @param InvoiceRequest $request The request object containing the updated invoice data.
     * @param string $id The ID of the invoice.
     * @return JsonResponse The JSON response containing the updated invoice.
     */
    public function update(string $company_id, InvoiceRequest $request, string $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $invoice = Invoice::findOrFail($id);
            $invoice->update($request->all());

            $invoice->lines()->delete();
            foreach ($request->input('lines', []) as $line) {
                $line['invoice_id'] = $invoice->id;
                InvoiceLine::create($line);
            }

            $invoice->dueDates()->delete();
            foreach ($request->input('due_dates', []) as $dueDate) {
                $dueDate['invoice_id'] = $invoice->id;
                InvoiceDueDate::create($dueDate);
            }

            $invoice->payments()->delete();
            foreach ($request->input('payments', []) as $payment) {
                $payment['invoice_id'] = $invoice->id;
                InvoicePayment::create($payment);
            }

            return response()->json($invoice->load(['lines', 'dueDates', 'payments']), 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Remove the specified invoice from storage.
     *
     * @param string $company_id The ID of the company.
     * @param string $id The ID of the invoice.
     * @return JsonResponse The JSON response confirming the deletion.
     */
    public function destroy(string $company_id, string $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $invoice = Invoice::findOrFail($id);
            $invoice->lines()->delete();
            $invoice->dueDates()->delete();
            $invoice->payments()->delete();
            $invoice->delete();

            return response()->json(["message" => "Invoice With Id: {$id} Has Been Deleted"], 200);
        }
        return response()->json(['message' => 'You dont have access this Company'], 403);
    }
}
