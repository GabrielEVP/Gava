<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;
use Tests\TestCase;

class SupplierControllerTest extends TestCase
{
    public function index_returns_suppliers_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        Supplier::factory()->count(3)->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/suppliers");

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function index_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();

        $response = $this->getJson("/api/companies/{$company->id}/suppliers");

        $response->assertStatus(403);
    }

    public function store_creates_new_supplier_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $supplierData = Supplier::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/suppliers", $supplierData);

        $response->assertStatus(201)
            ->assertJsonFragment($supplierData);
        $this->assertDatabaseHas('suppliers', $supplierData);
    }

    public function store_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $supplierData = Supplier::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/suppliers", $supplierData);

        $response->assertStatus(403);
    }

    public function show_returns_supplier_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $supplier = Supplier::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/suppliers/{$supplier->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($supplier->toArray());
    }

    public function show_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $supplier = Supplier::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/suppliers/{$supplier->id}");

        $response->assertStatus(403);
    }

    public function update_modifies_existing_supplier_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $supplier = Supplier::factory()->create(['company_id' => $company->id]);
        $updatedData = Supplier::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/suppliers/{$supplier->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('suppliers', $updatedData);
    }

    public function update_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $supplier = Supplier::factory()->create(['company_id' => $company->id]);
        $updatedData = Supplier::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/suppliers/{$supplier->id}", $updatedData);

        $response->assertStatus(403);
    }

    public function destroy_deletes_supplier_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $supplier = Supplier::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/suppliers/{$supplier->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => "Supplier With Id: {$supplier->id} Has Been Deleted"]);
        $this->assertDatabaseMissing('suppliers', ['id' => $supplier->id]);
    }

    public function destroy_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $supplier = Supplier::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/suppliers/{$supplier->id}");

        $response->assertStatus(403);
    }
}
