<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductPrice;

class ProductPriceSeeder extends Seeder
{
    public function run(): void
    {
        ProductPrice::factory()->count(20)->create();
    }
}
