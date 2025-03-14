<?php

namespace Tests\Feature;

use App\Models\TypePayment;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;

    private static array $CONSTDATAINVOICE = [
        'number' => 'INV-001',
        'date' => '2024-03-14',
        'status' => 'pending',
        'total_amount' => 500.00,
        'total_tax_amount' => 90.00,
        'invoice_lines' => [
            [
                'description' => 'Producto A',
                'quantity' => 2,
                'unit_price' => 100.00,
                'tax_rate' => 10.00,
                'total_amount' => 200.00,
                'total_tax_amount' => 220.00,
                'product_id' => null,
            ],
            [
                'description' => 'Servicio B',
                'quantity' => 1,
                'unit_price' => 300.00,
                'tax_rate' => 10.00,
                'total_amount' => 300.00,
                'total_tax_amount' => 330.00,
                'product_id' => null,
            ],
        ],
        'invoice_payments' => [
            [
                'date' => '2024-03-15',
                'amount' => 250.00,
                'type_payment_id' => 1,
            ],
        ],
        'invoice_due_dates' => [
            [
                'date' => '2024-04-01',
                'amount' => 250.00,
                'status' => 'pending',
            ],
        ],
    ];



    public function testIndexReturnsAllInvoices()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        Invoice::factory()->count(3)->create();
        $response = $this->getJson('/api/invoices');
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function testStoreCreatesInvoiceWithRelations()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $user = User::factory()->create();
        $client = Client::factory()->create();
        $typePayment = TypePayment::factory()->create();

        $invoiceData = self::$CONSTDATAINVOICE;
        $invoiceData['client_id'] = $client->id;
        $invoiceData['user_id'] = $user->id;

        foreach ($invoiceData['invoice_payments'] as &$payment) {
            $payment['type_payment_id'] = $typePayment->id;
        }

        $response = $this->postJson('/api/invoices', $invoiceData);
        $response->assertStatus(200)->assertJsonFragment(['number' => 'INV-001']);
        $this->assertDatabaseHas('invoices', ['status' => 'pending']);
    }

    public function testShowReturnsSpecificInvoice()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $invoice = Invoice::factory()->hasLines(1)->hasDueDates(1)->hasPayments(1)->create();
        $response = $this->getJson("/api/invoices/{$invoice->id}");
        $response->assertStatus(200)->assertJsonFragment(['id' => $invoice->id]);
    }

    public function testUpdateUpdatesInvoiceAndRelations()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $user = User::factory()->create();
        $client = Client::factory()->create();
        $typePayment = TypePayment::factory()->create();

        $invoiceData = self::$CONSTDATAINVOICE;
        $invoiceData['client_id'] = $client->id;
        $invoiceData['user_id'] = $user->id;

        foreach ($invoiceData['invoice_payments'] as &$payment) {
            $payment['type_payment_id'] = $typePayment->id;
        }

        $invoice = Invoice::factory()->hasLines(1)->hasDueDates(1)->hasPayments(1)->create();

        $response = $this->putJson("/api/invoices/{$invoice->id}", $invoiceData);
        $response->assertStatus(200)->assertJsonFragment(['number' => 'INV-001']);
        $this->assertDatabaseHas('invoices', ['status' => 'pending']);
    }
}
