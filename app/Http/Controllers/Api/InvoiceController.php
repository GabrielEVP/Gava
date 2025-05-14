<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Interfaces\PDFGeneratorInterface;

class InvoiceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search', '');
        $sort = $request->query('sort')['column'] ?? 'date';
        $order = strtolower($request->query('sort')['order'] ?? 'asc');

        $validColumns = ['id', 'number', 'status', 'date', 'total_amount', 'client_id'];

        if (!in_array($sort, $validColumns)) {
            return response()->json(['error' => 'Invalid sort column'], 400);
        }

        if (!in_array($order, ['asc', 'desc'])) {
            return response()->json(['error' => 'Invalid sort order'], 400);
        }

        $query = Invoice::with(['lines', 'payments', 'dueDates']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('number', 'LIKE', "%{$search}%")
                    ->orWhere('notes', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('select')) {
            foreach ($request->query('select') as $filter) {
                if (
                    !empty($filter['option']) &&
                    !empty($filter['value']) &&
                    in_array($filter['option'], $validColumns)
                ) {
                    $query->where($filter['option'], $filter['value']);
                }
            }
        }

        if ($request->has('dateRange')) {
            $dateRange = $request->query('dateRange');
            if (!empty($dateRange['start']) && !empty($dateRange['end'])) {
                $query->whereBetween('date', [$dateRange['start'], $dateRange['end']]);
            }
        }

        $query->orderBy($sort, $order);
        $invoices = $query->get();

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

        return response()->json($invoice->load(['lines', 'payments', 'dueDates']), 200);
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
    public function download(PDFGeneratorInterface $pdf, $invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        $client = $invoice->client;

        $content = $pdf->fromView('invoices.pdf', [
            'invoice' => $invoice,
            'client' => $client,
        ]);

        return response($content)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="Factura_' . $invoiceId . '.pdf"');
    }

    public function latestByClient(string $clientId): JsonResponse
    {
        $invoices = Invoice::with(['lines', 'payments', 'dueDates'])
            ->where('client_id', $clientId)
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        return response()->json($invoices, 200);
    }

}
