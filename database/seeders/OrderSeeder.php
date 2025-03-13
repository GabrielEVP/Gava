<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderLine;


class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::factory()->count(10)->create();
        OrderLine::factory()->count(10)->create();
    }
}
