<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    public function index_returns_companies_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Company::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/companies');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function store_creates_new_company(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $companyData = Company::factory()->make()->toArray();

        $response = $this->postJson('/api/companies', $companyData);

        $response->assertStatus(201)
            ->assertJsonFragment($companyData);
        $this->assertDatabaseHas('companies', $companyData);
    }

    public function show_returns_company_by_id(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/companies/{$company->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($company->toArray());
    }

    public function update_modifies_existing_company(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $updatedData = Company::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('companies', $updatedData);
    }

    public function destroy_deletes_company_by_id(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => "Company With Id: {$company->id} Has Been Deleted"]);
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }

    public function show_returns_404_for_non_existent_company(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/companies/999');

        $response->assertStatus(404);
    }

    public function update_returns_404_for_non_existent_company(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $updatedData = Company::factory()->make()->toArray();

        $response = $this->putJson('/api/companies/999', $updatedData);

        $response->assertStatus(404);
    }

    public function destroy_returns_404_for_non_existent_company(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->deleteJson('/api/companies/999');

        $response->assertStatus(404);
    }
}
