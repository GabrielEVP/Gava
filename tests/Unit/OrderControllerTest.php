<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    private static array $CONSTDATAORDER = [
        'number' => 'ORD-001',
        'date' => '2024-03-14',
        'status' => 'pending',
        'total_amount' => 500.00,
        'total_tax_amount' => 90.00,
        'order_lines' => [
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
    ];



    public function testIndexReturnsAllOrders()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        Order::factory()->count(3)->create();
        $response = $this->getJson('/api/orders');
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function testStoreCreatesOrderWithRelations()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $user = User::factory()->create();
        $client = Client::factory()->create();

        $orderData = self::$CONSTDATAORDER;
        $orderData['client_id'] = $client->id;
        $orderData['user_id'] = $user->id;

        $response = $this->postJson('/api/orders', $orderData);
        $response->assertStatus(200)->assertJsonFragment(['number' => 'ORD-001']);
        $this->assertDatabaseHas('orders', ['status' => 'pending']);
    }

    public function testShowReturnsSpecificOrder()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $Order = Order::factory()->hasLines(1)->create();
        $response = $this->getJson("/api/orders/{$Order->id}");
        $response->assertStatus(200)->assertJsonFragment(['id' => $Order->id]);
    }

    public function testUpdateUpdatesOrderAndRelations()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $user = User::factory()->create();
        $client = Client::factory()->create();

        $orderData = self::$CONSTDATAORDER;
        $orderData['client_id'] = $client->id;
        $orderData['user_id'] = $user->id;

        $Order = Order::factory()->hasLines(1)->create();

        $response = $this->putJson("/api/orders/{$Order->id}", $orderData);
        $response->assertStatus(200)->assertJsonFragment(['number' => 'ORD-001']);
        $this->assertDatabaseHas('orders', ['status' => 'pending']);
    }
}
