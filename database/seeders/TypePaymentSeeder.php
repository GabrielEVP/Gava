<?php

namespace Database\Seeders;

use App\Models\TypePayment;
use Illuminate\Database\Seeder;

class TypePaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypePayment::factory()->count(10)->create();
    }
}
