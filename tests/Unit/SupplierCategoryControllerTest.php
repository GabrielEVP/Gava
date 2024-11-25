<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\SupplierCategory;
use App\Models\User;
use Tests\TestCase;

class SupplierCategoryControllerTest extends TestCase
{
    public function index_returns_supplier_categories_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        SupplierCategory::factory()->count(3)->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/supplier-categories");

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function index_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();

        $response = $this->getJson("/api/companies/{$company->id}/supplier-categories");

        $response->assertStatus(403);
    }

    public function store_creates_new_supplier_category_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $categoryData = SupplierCategory::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/supplier-categories", $categoryData);

        $response->assertStatus(201)
            ->assertJsonFragment($categoryData);
        $this->assertDatabaseHas('supplier_categories', $categoryData);
    }

    public function store_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $categoryData = SupplierCategory::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/supplier-categories", $categoryData);

        $response->assertStatus(403);
    }

    public function show_returns_supplier_category_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $category = SupplierCategory::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/supplier-categories/{$category->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($category->toArray());
    }

    public function show_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $category = SupplierCategory::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/supplier-categories/{$category->id}");

        $response->assertStatus(403);
    }

    public function update_modifies_existing_supplier_category_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $category = SupplierCategory::factory()->create(['company_id' => $company->id]);
        $updatedData = SupplierCategory::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/supplier-categories/{$category->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('supplier_categories', $updatedData);
    }

    public function update_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $category = SupplierCategory::factory()->create(['company_id' => $company->id]);
        $updatedData = SupplierCategory::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/supplier-categories/{$category->id}", $updatedData);

        $response->assertStatus(403);
    }

    public function destroy_deletes_supplier_category_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $category = SupplierCategory::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/supplier-categories/{$category->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => "SupplierCategory With Id: {$category->id} Has Been Deleted"]);
        $this->assertDatabaseMissing('supplier_categories', ['id' => $category->id]);
    }

    public function destroy_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $category = SupplierCategory::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/supplier-categories/{$category->id}");

        $response->assertStatus(403);
    }
}
