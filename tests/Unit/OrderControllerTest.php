<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Order;
use App\Models\User;
use Tests\Feature\OrderLine;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    public function index_returns_orders_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        Order::factory()->count(3)->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/orders");

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function index_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();

        $response = $this->getJson("/api/companies/{$company->id}/orders");

        $response->assertStatus(403);
    }

    public function store_creates_new_order_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $orderData = Order::factory()->make()->toArray();
        $orderLinesData = OrderLine::factory()->count(2)->make()->toArray();
        $orderData['order_lines'] = $orderLinesData;

        $response = $this->postJson("/api/companies/{$company->id}/orders", $orderData);

        $response->assertStatus(201)
            ->assertJsonFragment($orderData);
        $this->assertDatabaseHas('orders', $orderData);
        foreach ($orderLinesData as $line) {
            $this->assertDatabaseHas('order_lines', $line);
        }
    }

    public function store_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $orderData = Order::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/orders", $orderData);

        $response->assertStatus(403);
    }

    public function show_returns_order_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $order = Order::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/orders/{$order->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($order->toArray());
    }

    public function show_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $order = Order::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/orders/{$order->id}");

        $response->assertStatus(403);
    }

    public function update_modifies_existing_order_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $order = Order::factory()->create(['company_id' => $company->id]);
        $updatedData = Order::factory()->make()->toArray();
        $updatedOrderLinesData = OrderLine::factory()->count(2)->make()->toArray();
        $updatedData['order_lines'] = $updatedOrderLinesData;

        $response = $this->putJson("/api/companies/{$company->id}/orders/{$order->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('orders', $updatedData);
        foreach ($updatedOrderLinesData as $line) {
            $this->assertDatabaseHas('order_lines', $line);
        }
    }

    public function update_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $order = Order::factory()->create(['company_id' => $company->id]);
        $updatedData = Order::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/orders/{$order->id}", $updatedData);

        $response->assertStatus(403);
    }

    public function destroy_deletes_order_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $order = Order::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/orders/{$order->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => "Order With Id: {$order->id} Has Been Deleted"]);
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }

    public function destroy_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $order = Order::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/orders/{$order->id}");

        $response->assertStatus(403);
    }
}
