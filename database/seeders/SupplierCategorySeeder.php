<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SupplierCategory;

class SupplierCategorySeeder extends Seeder
{
    public function run(): void
    {
        SupplierCategory::factory()->count(5)->create();
    }
}
