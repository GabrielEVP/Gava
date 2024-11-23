<?php

namespace Database\Factories;

use App\Models\TypePrice;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypePriceFactory extends Factory
{
    protected $model = TypePrice::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'percentage' => $this->faker->randomFloat(2, 0, 100),
            'company_id' => Company::factory(),
        ];
    }
}
