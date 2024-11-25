<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Tests\Feature\ProductPrice;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    public function index_returns_products_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        Product::factory()->count(3)->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/products");

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function index_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();

        $response = $this->getJson("/api/companies/{$company->id}/products");

        $response->assertStatus(403);
    }

    public function store_creates_new_product_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $productData = Product::factory()->make()->toArray();
        $productPricesData = ProductPrice::factory()->count(2)->make()->toArray();
        $productData['product_prices'] = $productPricesData;

        $response = $this->postJson("/api/companies/{$company->id}/products", $productData);

        $response->assertStatus(201)
            ->assertJsonFragment($productData);
        $this->assertDatabaseHas('products', $productData);
        foreach ($productPricesData as $price) {
            $this->assertDatabaseHas('product_prices', $price);
        }
    }

    public function store_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $productData = Product::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/products", $productData);

        $response->assertStatus(403);
    }

    public function show_returns_product_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($product->toArray());
    }

    public function show_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $product = Product::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/products/{$product->id}");

        $response->assertStatus(403);
    }

    public function update_modifies_existing_product_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['company_id' => $company->id]);
        $updatedData = Product::factory()->make()->toArray();
        $updatedProductPricesData = ProductPrice::factory()->count(2)->make()->toArray();
        $updatedData['product_prices'] = $updatedProductPricesData;

        $response = $this->putJson("/api/companies/{$company->id}/products/{$product->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('products', $updatedData);
        foreach ($updatedProductPricesData as $price) {
            $this->assertDatabaseHas('product_prices', $price);
        }
    }

    public function update_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $product = Product::factory()->create(['company_id' => $company->id]);
        $updatedData = Product::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/products/{$product->id}", $updatedData);

        $response->assertStatus(403);
    }

    public function destroy_deletes_product_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => "Product With Id: {$product->id} Has Been Deleted"]);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function destroy_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $product = Product::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/products/{$product->id}");

        $response->assertStatus(403);
    }
}
