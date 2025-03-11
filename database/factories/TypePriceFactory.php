<?php

namespace Database\Factories;

use App\Models\TypePrice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypePriceFactory extends Factory
{
    protected $model = TypePrice::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'margin' => '20',
            'type' => 'fixed',
            'user_id' => User::factory(),
        ];
    }
}
