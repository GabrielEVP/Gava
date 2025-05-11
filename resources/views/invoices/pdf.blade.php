<div class="invoice-container">
    <!-- Header -->
    <div class="invoice-header">
        <h1>Invoice #{{ $invoice->id }}</h1>
        <p>Date: {{ $invoice->date }}</p>
    </div>

    <!-- Invoice Details -->
    <div class="invoice-details">
        <!-- Bill To -->
        <div class="invoice-to">
            <h3>Bill To:</h3>
            <p><strong>Name:</strong> {{ $invoice->customer_name }}</p>
            <p><strong>Address:</strong> {{ $invoice->customer_address }}</p>
            <p><strong>Email:</strong> {{ $invoice->customer_email }}</p>
        </div>

        <!-- From -->
        <div class="invoice-from">
            <h3>From:</h3>
            <p><strong>Client:</strong> {{ $client->legal_name }}</p>
            <p><strong>Address:</strong> {{ $client->addresses->first()->address ?? 'No address available' }}</p>
            <p><strong>Phone:</strong> {{ $client->phones->first()->phone ?? 'No phone available' }}</p>
        </div>
    </div>

    <!-- Invoice Lines -->
    <div class="invoice-lines">
        <h3>Invoice Lines:</h3>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->lines as $line)
                    <tr>
                        <td>{{ $line->description }}</td>
                        <td>{{ $line->quantity }}</td>
                        <td>{{ number_format($line->unit_price, 2) }}</td>
                        <td>{{ number_format($line->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Invoice Summary -->
    <div class="invoice-summary">
        <div class="summary-line">
            <span>Subtotal:</span>
            <span>{{ number_format($invoice->subtotal, 2) }}</span>
        </div>
        <div class="summary-line">
            <span>Tax ({{ $invoice->tax_percentage }}%):</span>
            <span>{{ number_format($invoice->tax_amount, 2) }}</span>
        </div>
        <div class="summary-line total">
            <span><strong>Total:</strong></span>
            <span><strong>{{ number_format($invoice->total, 2) }}</strong></span>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    .invoice-container {
        font-family: Arial, sans-serif;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 10px;
    }

    .invoice-header h1 {
        font-size: 28px;
        color: #333;
        margin-bottom: 10px;
        border-bottom: 2px solid #ccc;
        padding-bottom: 10px;
    }

    .invoice-header p {
        font-size: 16px;
        color: #666;
    }

    .invoice-details {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .invoice-to,
    .invoice-from {
        width: 45%;
    }

    .invoice-to h3,
    .invoice-from h3 {
        font-size: 18px;
        color: #333;
        margin-bottom: 5px;
    }

    .invoice-to p,
    .invoice-from p {
        font-size: 14px;
        color: #666;
    }

    .invoice-lines {
        margin-top: 30px;
    }

    .invoice-lines h3 {
        font-size: 20px;
        color: #333;
        margin-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        font-size: 14px;
        color: #555;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    td {
        border-bottom: 1px solid #ddd;
    }

    .invoice-summary {
        margin-top: 30px;
        padding-top: 10px;
        border-top: 2px solid #ccc;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        font-size: 16px;
        color: #555;
        margin-top: 8px;
    }

    .total {
        font-weight: bold;
        font-size: 18px;
        color: #333;
    }

    .summary-line span {
        padding: 3px 0;
    }
</style>