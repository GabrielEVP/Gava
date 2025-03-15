<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\User;
use App\Models\TypePrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    private static array $CONSTDATA = [
        'name' => 'Producto de prueba',
        'description' => 'Descripción del producto de prueba',
        'barcode' => '123456789',
        'reference_code' => 'REF-001',
        'purchase_price' => 50.00,
        'tax_rate' => 10.00,
        'stock_quantity' => 100,
        'units_per_box' => 10,
        'prices' => [
            [
                'price' => 60.00,
                'type_price_id' => null,
            ],
            [
                'price' => 70.00,
                'type_price_id' => null,
            ]
        ]
    ];

    public function testIndexReturnsAllProducts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products');
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function testStoreCreatesProductWithRelations()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $typePrice1 = TypePrice::factory()->create();
        $typePrice2 = TypePrice::factory()->create();

        $productData = self::$CONSTDATA;
        $productData['user_id'] = $user->id;
        $productData['prices'][0]['type_price_id'] = $typePrice1->id;
        $productData['prices'][1]['type_price_id'] = $typePrice2->id;

        $response = $this->postJson('/api/products', $productData);
        $response->assertStatus(200)->assertJsonFragment(['name' => 'Producto de prueba']);
        $this->assertDatabaseHas('products', ['name' => 'Producto de prueba']);
        $this->assertDatabaseHas('product_prices', ['price' => 60.00]);
        $this->assertDatabaseHas('product_prices', ['price' => 70.00]);
    }

    public function testShowReturnsSpecificProduct()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();
        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)->assertJsonFragment(['id' => $product->id]);
    }

    public function testUpdateUpdatesProductAndRelations()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $typePrice1 = TypePrice::factory()->create();
        $typePrice2 = TypePrice::factory()->create();

        $productData = self::$CONSTDATA;
        $productData['user_id'] = $user->id;
        $productData['prices'][0]['type_price_id'] = $typePrice1->id;
        $productData['prices'][1]['type_price_id'] = $typePrice2->id;

        $response = $this->putJson("/api/products/{$product->id}", $productData);
        $response->assertStatus(200)->assertJsonFragment(['name' => 'Producto de prueba']);
        $this->assertDatabaseHas('products', ['name' => 'Producto de prueba']);
        $this->assertDatabaseHas('product_prices', ['price' => 60.00]);
        $this->assertDatabaseHas('product_prices', ['price' => 70.00]);
    }

    public function testDestroyDeletesProductAndRelations()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");
        $response->assertStatus(200)->assertJson(['message' => "Product With Id: {$product->id} Has Been Deleted"]);
    }

    public function testAttachProductToSupplier()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $typePrice1 = TypePrice::factory()->create();
        $typePrice2 = TypePrice::factory()->create();

        $productData = self::$CONSTDATA;
        $productData['user_id'] = $user->id;
        $productData['prices'][0]['type_price_id'] = $typePrice1->id;
        $productData['prices'][1]['type_price_id'] = $typePrice2->id;

        $product = Product::create($productData);
        $supplier = Supplier::factory()->create();
        $product->suppliers()->attach($supplier->id);

        $this->assertDatabaseHas('products_suppliers', [
            'product_id' => $product->id,
            'supplier_id' => $supplier->id,
        ]);
    }

    public function testAttachProductToCategory()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $typePrice1 = TypePrice::factory()->create();
        $typePrice2 = TypePrice::factory()->create();

        $productData = self::$CONSTDATA;
        $productData['user_id'] = $user->id;
        $productData['prices'][0]['type_price_id'] = $typePrice1->id;
        $productData['prices'][1]['type_price_id'] = $typePrice2->id;

        $product = Product::create($productData);
        $category = Category::factory()->create();
        $product->categories()->attach($category->id);

        $this->assertDatabaseHas('products_categories', [
            'product_id' => $product->id,
            'category_id' => $category->id,
        ]);
    }
}
