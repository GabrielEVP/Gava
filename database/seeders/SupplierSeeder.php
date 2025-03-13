<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\SupplierAddress;
use App\Models\SupplierPhone;
use App\Models\SupplierEmail;
use App\Models\SupplierBankAccount;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::factory()->count(10)->create();
        SupplierAddress::factory()->count(10)->create();
        SupplierPhone::factory()->count(10)->create();
        SupplierEmail::factory()->count(10)->create();
        SupplierBankAccount::factory()->count(10)->create();
    }
}
