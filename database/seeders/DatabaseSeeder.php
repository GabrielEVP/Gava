<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProductSeeder::class,
            UserSeeder::class,
            SupplierSeeder::class,
            TypePriceSeeder::class,
            TypePaymentSeeder::class,
            ClientSeeder::class,
            ClientEmailSeeder::class,
            ClientPhoneSeeder::class,
            InvoiceDueDateSeeder::class,
            InvoiceLineSeeder::class,
            InvoiceSeeder::class,
            InvoicePaymentSeeder::class,
        ]);
    }
}
