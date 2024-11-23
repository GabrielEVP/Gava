<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\Company;
use App\Models\SupplierCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'legal_name' => $this->faker->companySuffix() . ' ' . $this->faker->company(),
            'vat_number' => $this->faker->unique()->numerify('VAT#######'),
            'registration_number' => $this->faker->unique()->numerify('REG#######'),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'website' => $this->faker->url(),
            'category_id' => $this->faker->numberBetween(1, 10), // O ajusta según la lógica de tu sistema
            'company_id' => Company::factory(),
            'supplier_category_id' => SupplierCategory::factory(),
        ];
    }
}
