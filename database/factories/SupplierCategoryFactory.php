<?php

namespace Database\Factories;

use App\Models\SupplierCategory;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierCategoryFactory extends Factory
{
    protected $model = SupplierCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'company_id' => Company::factory(),
        ];
    }
}
