<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\PurchaseLine;
use App\Models\PurchasePayment;
use App\Models\PurchaseDueDate;


class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        Purchase::factory()->count(10)->create();
        PurchaseLine::factory()->count(10)->create();
        PurchasePayment::factory()->count(10)->create();
        PurchaseDueDate::factory()->count(10)->create();
    }
}
