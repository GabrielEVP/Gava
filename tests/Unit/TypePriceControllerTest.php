<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\TypePrice;
use App\Models\User;
use Tests\TestCase;

class TypePriceControllerTest extends TestCase
{
    public function index_returns_type_prices_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        TypePrice::factory()->count(3)->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/type-prices");

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function index_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();

        $response = $this->getJson("/api/companies/{$company->id}/type-prices");

        $response->assertStatus(403);
    }

    public function store_creates_new_type_price_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $typePriceData = TypePrice::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/type-prices", $typePriceData);

        $response->assertStatus(201)
            ->assertJsonFragment($typePriceData);
        $this->assertDatabaseHas('type_prices', $typePriceData);
    }

    public function store_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $typePriceData = TypePrice::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/type-prices", $typePriceData);

        $response->assertStatus(403);
    }

    public function show_returns_type_price_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $typePrice = TypePrice::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/type-prices/{$typePrice->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($typePrice->toArray());
    }

    public function show_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $typePrice = TypePrice::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/type-prices/{$typePrice->id}");

        $response->assertStatus(403);
    }

    public function update_modifies_existing_type_price_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $typePrice = TypePrice::factory()->create(['company_id' => $company->id]);
        $updatedData = TypePrice::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/type-prices/{$typePrice->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('type_prices', $updatedData);
    }

    public function update_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $typePrice = TypePrice::factory()->create(['company_id' => $company->id]);
        $updatedData = TypePrice::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/type-prices/{$typePrice->id}", $updatedData);

        $response->assertStatus(403);
    }

    public function destroy_deletes_type_price_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $typePrice = TypePrice::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/type-prices/{$typePrice->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => "TypePrices With Id: {$typePrice->id} Has Been Deleted"]);
        $this->assertDatabaseMissing('type_prices', ['id' => $typePrice->id]);
    }

    public function destroy_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $typePrice = TypePrice::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/type-prices/{$typePrice->id}");

        $response->assertStatus(403);
    }
}
