<?php

namespace Tests\Feature;

use App\Models\Supplier;
use App\Models\TypePayment;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseControllerTest extends TestCase
{
    use RefreshDatabase;

    private static array $CONSTDATAPURCHASE = [
        'number' => 'PUR-001',
        'date' => '2024-03-14',
        'status' => 'pending',
        'total_amount' => 500.00,
        'total_tax_amount' => 90.00,
        'purchase_lines' => [
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
        'purchase_payments' => [
            [
                'date' => '2024-03-15',
                'amount' => 250.00,
                'type_payment_id' => 1,
            ],
        ],
        'purchase_due_dates' => [
            [
                'date' => '2024-04-01',
                'amount' => 250.00,
                'status' => 'pending',
            ],
        ],
    ];



    public function testIndexReturnsAllPurchases()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        Purchase::factory()->count(3)->create();
        $response = $this->getJson('/api/purchases');
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function testStoreCreatesPurchaseWithRelations()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $user = User::factory()->create();
        $supplier = Supplier::factory()->create();
        $typePayment = TypePayment::factory()->create();

        $PurchaseData = self::$CONSTDATAPURCHASE;
        $PurchaseData['supplier_id'] = $supplier->id;
        $PurchaseData['user_id'] = $user->id;

        foreach ($PurchaseData['purchase_payments'] as &$payment) {
            $payment['type_payment_id'] = $typePayment->id;
        }

        $response = $this->postJson('/api/purchases', $PurchaseData);
        $response->assertStatus(200)->assertJsonFragment(['number' => 'PUR-001']);
        $this->assertDatabaseHas('purchases', ['status' => 'pending']);
    }

    public function testShowReturnsSpecificPurchase()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $purchase = Purchase::factory()->hasLines(1)->hasDueDates(1)->hasPayments(1)->create();
        $response = $this->getJson("/api/purchases/{$purchase->id}");
        $response->assertStatus(200)->assertJsonFragment(['id' => $purchase->id]);
    }

    public function testUpdateUpdatesPurchaseAndRelations()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $user = User::factory()->create();
        $supplier = Supplier::factory()->create();
        $typePayment = TypePayment::factory()->create();

        $PurchaseData = self::$CONSTDATAPURCHASE;
        $PurchaseData['supplier_id'] = $supplier->id;
        $PurchaseData['user_id'] = $user->id;

        foreach ($PurchaseData['purchase_payments'] as &$payment) {
            $payment['type_payment_id'] = $typePayment->id;
        }

        $purchase = Purchase::factory()->hasLines(1)->hasDueDates(1)->hasPayments(1)->create();

        $response = $this->putJson("/api/purchases/{$purchase->id}", $PurchaseData);
        $response->assertStatus(200)->assertJsonFragment(['number' => 'PUR-001']);
        $this->assertDatabaseHas('purchases', ['status' => 'pending']);
    }

    public function testpaidPurchaseAndDeliveredProducts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $purchase = Purchase::factory()->create([
            'status' => 'pending',
            'user_id' => $user->id
        ]);

        $lines = [
            [
                'description' => 'Producto A',
                'quantity' => 2,
                'unit_price' => 100.00,
                'total_amount' => 200.00,
                'total_tax_amount' => 220.00,
                'tax_rate' => 10.00,
                'product_id' => null,
            ],
        ];

        foreach ($lines as $line) {
            $purchase->lines()->create($line);
        }

        $response = $this->putJson("/api/purchases/paid/{$purchase->id}");

        $response->assertStatus(200)->assertJson(['message' => "Products attached (or created and attached) successfully"]);

        foreach ($purchase->lines as $line) {
            $this->assertTrue($line->status == 'delivered');
            $this->assertNotNull($line->product_id);
            $this->assertDatabaseHas('products', ['id' => $line->product_id]);
        }
    }
}
