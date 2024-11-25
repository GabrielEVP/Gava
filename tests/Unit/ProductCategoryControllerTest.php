<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\ProductCategory;
use App\Models\User;
use Tests\TestCase;

class ProductCategoryControllerTest extends TestCase
{
    public function index_returns_product_categories_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        ProductCategory::factory()->count(3)->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/product-categories");

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function index_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();

        $response = $this->getJson("/api/companies/{$company->id}/product-categories");

        $response->assertStatus(403);
    }

    public function store_creates_new_product_category_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $categoryData = ProductCategory::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/product-categories", $categoryData);

        $response->assertStatus(201)
            ->assertJsonFragment($categoryData);
        $this->assertDatabaseHas('product_categories', $categoryData);
    }

    public function store_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $categoryData = ProductCategory::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/product-categories", $categoryData);

        $response->assertStatus(403);
    }

    public function show_returns_product_category_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $category = ProductCategory::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/product-categories/{$category->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($category->toArray());
    }

    public function show_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $category = ProductCategory::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/product-categories/{$category->id}");

        $response->assertStatus(403);
    }

    public function update_modifies_existing_product_category_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $category = ProductCategory::factory()->create(['company_id' => $company->id]);
        $updatedData = ProductCategory::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/product-categories/{$category->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('product_categories', $updatedData);
    }

    public function update_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $category = ProductCategory::factory()->create(['company_id' => $company->id]);
        $updatedData = ProductCategory::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/product-categories/{$category->id}", $updatedData);

        $response->assertStatus(403);
    }

    public function destroy_deletes_product_category_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $category = ProductCategory::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/product-categories/{$category->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => "ProductCategory With Id: {$category->id} Has Been Deleted"]);
        $this->assertDatabaseMissing('product_categories', ['id' => $category->id]);
    }

    public function destroy_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $category = ProductCategory::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/product-categories/{$category->id}");

        $response->assertStatus(403);
    }
}
