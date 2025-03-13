<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ClientSeeder::class,
            InvoiceSeeder::class,
            OrderSeeder::class,
            ProductSeeder::class,
            PurchaseSeeder::class,
            SupplierSeeder::class,
            TypePaymentSeeder::class,
            TypePriceSeeder::class,
            UserSeeder::class,
        ]);
    }
}
