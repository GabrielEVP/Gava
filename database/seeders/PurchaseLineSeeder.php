<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseLine;

class PurchaseLineSeeder extends Seeder
{
    public function run(): void
    {
        PurchaseLine::factory()->count(10)->create();
    }
}
