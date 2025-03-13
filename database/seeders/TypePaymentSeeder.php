<?php

namespace Database\Seeders;

use App\Models\TypePayment;
use Illuminate\Database\Seeder;

class TypePaymentSeeder extends Seeder
{
    public function run(): void
    {
        TypePayment::factory()->count(10)->create();
    }
}
