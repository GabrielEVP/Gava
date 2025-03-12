<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    public function index(): JsonResponse
    {
        $invoices = Invoice::with(['lines', 'payments', 'dueDates'])->get();
        return response()->json($invoices, 200);
    }

    public function store(InvoiceRequest $request): JsonResponse
    {
        $invoice = Invoice::create($request->all());

        $lines = $request->input('lines', []);
        foreach ($lines as $line) {
            $invoice->lines()->create($line);
        }

        $payments = $request->input('payments', []);
        foreach ($payments as $payment) {
            $invoice->payments()->create($payment);
        }

        $dueDates = $request->input('due_dates', []);
        foreach ($dueDates as $dueDate) {
            $invoice->dueDates()->create($dueDate);
        }

        return response()->json($invoice->load(['lines', 'payments', 'dueDates']), 201);
    }

    public function show(string $id): JsonResponse
    {
        $invoice = Invoice::with(['lines', 'payments', 'dueDates'])->findOrFail($id);
        return response()->json($invoice, 200);
    }

    public function update(InvoiceRequest $request, string $id): JsonResponse
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->all());

        $invoice->lines()->delete();
        foreach ($request->input('lines', []) as $line) {
            $invoice->lines()->create($line);
        }

        $invoice->payments()->delete();
        foreach ($request->input('payments', []) as $payment) {
            $invoice->payments()->create($payment);
        }

        $invoice->dueDates()->delete();
        foreach ($request->input('due_dates', []) as $dueDate) {
            $invoice->dueDates()->create($dueDate);
        }

        return response()->json($invoice->load(['lines', 'payments', 'dueDates']), 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->lines()->delete();
        $invoice->payments()->delete();
        $invoice->dueDates()->delete();
        $invoice->delete();

        return response()->json(["message" => "Invoice With Id: {$id} Has Been Deleted"], 200);
    }
}
