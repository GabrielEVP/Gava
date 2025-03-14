<?php

namespace Tests\Feature;

use App\Models\TypePrice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TypePriceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['password' => bcrypt('password')]);
        $this->actingAs($user);
    }

    public function testIndexReturnsAllTypePrices()
    {
        TypePrice::factory()->count(3)->create();

        $response = $this->getJson('/api/type_prices');
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function testStoreCreatesANewTypePrice()
    {
        $typePriceData = [
            'name' => 'Fixed Price',
            'description' => 'A fixed price type',
            'type' => 'fixed',
            'margin' => 10.5,
        ];

        $response = $this->postJson('/api/type_prices', $typePriceData);

        $response->assertStatus(201)->assertJson($typePriceData);
        $this->assertDatabaseHas('type_prices', $typePriceData);
    }

    public function testShowReturnsTheRequestedTypePrice()
    {
        $typePrice = TypePrice::factory()->create();

        $response = $this->getJson("/api/type_prices/{$typePrice->id}");
        $response->assertStatus(200)->assertJson($typePrice->toArray());
    }

    public function testUpdateModifiesAnExistingTypePrice()
    {
        $typePrice = TypePrice::factory()->create();

        $updatedData = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'type' => 'percentage',
            'margin' => 20.0,
        ];

        $response = $this->putJson("/api/type_prices/{$typePrice->id}", $updatedData);

        $response->assertStatus(200)->assertJson($updatedData);
        $this->assertDatabaseHas('type_prices', $updatedData);
    }

    public function testDestroyDeletesAnExistingTypePrice()
    {
        $typePrice = TypePrice::factory()->create();

        $response = $this->deleteJson("/api/type_prices/{$typePrice->id}");
        $response->assertStatus(200)->assertJson(['message' => "Type Price With Id: {$typePrice->id} Has Been Deleted"]);
    }

    public function testStoreFailsWithInvalidData()
    {
        $invalidData = [
            'name' => '',
            'description' => 'A description',
            'type' => 'invalid_type',
            'margin' => 150,
        ];

        $response = $this->postJson('/api/type_prices', $invalidData);
        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'type', 'margin']);
    }

    public function testUpdateFailsWithInvalidData()
    {
        $typePrice = TypePrice::factory()->create();

        $invalidData = [
            'name' => '',
            'description' => 'A description',
            'type' => 'invalid_type',
            'margin' => 150,
        ];

        $response = $this->putJson("/api/type_prices/{$typePrice->id}", $invalidData);
        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'type', 'margin']);
    }
}