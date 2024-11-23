<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'legal_name' => $this->faker->companySuffix(),
            'vat_number' => $this->faker->regexify('[A-Z]{2}[0-9]{9}'),
            'registration_number' => $this->faker->unique()->numerify('REG-#####'),
            'email' => $this->faker->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'website' => $this->faker->url(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'currency' => $this->faker->currencyCode(),
            'bank_account' => $this->faker->bankAccountNumber(),
            'invoice_prefix' => $this->faker->lexify('INV-???'),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'logo_url' => $this->faker->imageUrl(),
            'industry' => $this->faker->word(),
            'number_of_employees' => $this->faker->numberBetween(1, 1000),
            'notes' => $this->faker->paragraph(),
            'user_id' => User::factory(),
        ];
    }
}
