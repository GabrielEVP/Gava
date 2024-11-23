<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypePrice;

class TypePriceSeeder extends Seeder
{
    public function run(): void
    {
        TypePrice::factory()->count(10)->create();
    }
}
