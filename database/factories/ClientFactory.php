<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'legal_name' => $this->faker->companySuffix(),
            'vat_number' => $this->faker->regexify('[A-Z]{2}[0-9]{9}'),
            'registration_number' => $this->faker->regexify('[A-Z]{3}-[0-9]{5}'),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'website' => $this->faker->url(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'currency' => $this->faker->currencyCode(),
            'tax_rate' => $this->faker->randomFloat(2, 0, 20),
            'payment_terms' => $this->faker->numberBetween(0, 30), // Ensure payment_terms is an integer
            'contact_person' => $this->faker->name(),
            'notes' => $this->faker->sentence(),
            'company_id' => Company::factory(),
        ];
    }
}
