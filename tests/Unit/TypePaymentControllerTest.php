<?php

namespace Tests\Feature;
use App\Models\User;
use App\Models\TypePayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TypePaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsAllTypePayments()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        TypePayment::factory()->count(3)->create();

        $response = $this->getJson('/api/type_payments');
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function testStoreCreatesANewTypePayment()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $typePaymentData = [
            'name' => 'Credit Card',
            'description' => 'Payment via credit card',
        ];

        $response = $this->postJson('/api/type_payments', $typePaymentData);
        $response->assertStatus(200)->assertJson($typePaymentData);
        $this->assertDatabaseHas('type_payments', $typePaymentData);
    }

    public function testShowReturnsTheRequestedTypePayment()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $typePayment = TypePayment::factory()->create();

        $response = $this->getJson("/api/type_payments/{$typePayment->id}");
        $response->assertStatus(200)->assertJson($typePayment->toArray());
    }

    public function testUpdateModifiesAnExistingTypePayment()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $typePayment = TypePayment::factory()->create();

        $updatedData = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
        ];

        $response = $this->putJson("/api/type_payments/{$typePayment->id}", $updatedData);
        $response->assertStatus(200)->assertJson($updatedData);

        $this->assertDatabaseHas('type_payments', $updatedData);
    }

    public function testDestroyDeletesAnExistingTypePayment()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $typePayment = TypePayment::factory()->create();

        $response = $this->deleteJson("/api/type_payments/{$typePayment->id}");
        $response->assertStatus(200)->assertJson(['message' => "Type Payment With Id: {$typePayment->id} Has Been Deleted"]);
        $this->assertDatabaseMissing('type_payments', ['id' => $typePayment->id]);
    }
}