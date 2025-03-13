<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\InvoicePayment;
use App\Models\InvoiceDueDate;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        Invoice::factory()->count(10)->create();
        InvoiceLine::factory()->count(10)->create();
        InvoicePayment::factory()->count(10)->create();
        InvoiceDueDate::factory()->count(10)->create();
    }
}
