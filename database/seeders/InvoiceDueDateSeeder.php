<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvoiceDueDate;

class InvoiceDueDateSeeder extends Seeder
{
    public function run(): void
    {
        InvoiceDueDate::factory()->count(10)->create();
    }
}
