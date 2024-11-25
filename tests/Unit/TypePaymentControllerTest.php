<?php

namespace Tests\Unit;

use App\Models\TypePayment;
use Tests\TestCase;

class TypePaymentControllerTest extends TestCase
{
    public function index_returns_all_type_payments(): void
    {
        TypePayment::factory()->count(3)->create();

        $response = $this->getJson('/api/type-payments');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function store_creates_new_type_payment(): void
    {
        $typePaymentData = TypePayment::factory()->make()->toArray();

        $response = $this->postJson('/api/type-payments', $typePaymentData);

        $response->assertStatus(201)
            ->assertJsonFragment($typePaymentData);
        $this->assertDatabaseHas('type_payments', $typePaymentData);
    }

    public function show_returns_type_payment_by_id(): void
    {
        $typePayment = TypePayment::factory()->create();

        $response = $this->getJson("/api/type-payments/{$typePayment->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($typePayment->toArray());
    }

    public function update_modifies_existing_type_payment(): void
    {
        $typePayment = TypePayment::factory()->create();
        $updatedData = TypePayment::factory()->make()->toArray();

        $response = $this->putJson("/api/type-payments/{$typePayment->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('type_payments', $updatedData);
    }

    public function destroy_deletes_type_payment_by_id(): void
    {
        $typePayment = TypePayment::factory()->create();

        $response = $this->deleteJson("/api/type-payments/{$typePayment->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'TypePayment deleted successfully']);
        $this->assertDatabaseMissing('type_payments', ['id' => $typePayment->id]);
    }
}
