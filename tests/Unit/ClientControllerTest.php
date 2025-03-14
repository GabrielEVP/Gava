<?php

namespace Tests\Feature;

use App\Models\USer;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    private static array $CONSTDATACLIENT = [
        'registration_number' => 'REG-002',
        'legal_name' => 'Test Client',
        'type' => 'JU',
        'website' => 'https://updated.com',
        'country' => 'France',
        'currency' => 'EUR',
        'tax_rate' => 18.00,
        'discount' => 10.00,
        'notes' => 'Notas actualizadas',
        'addresses' => [
            [
                'address' => 'Avenida Siempre Viva 742',
                'state' => 'París',
                'municipality' => 'París',
                'postal_code' => '75000',
                'country' => 'France',
                'is_billing' => false,
            ],
        ],
        'phones' => [
            ['name' => 'Personal', 'phone' => '612345678', 'type' => 'Personal'],
        ],
        'emails' => [
            ['email' => 'updated@example.com', 'type' => 'Personal'],
        ],
        'bank_accounts' => [
            ['name' => 'Cuenta Secundaria', 'account_number' => 'FR0987654321098765432109', 'type' => 'CO'],
        ],
    ];

    public function testIndexReturnsAllClients()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        Client::factory()->count(3)->create();
        $response = $this->getJson('/api/clients');
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function testStoreCreatesClientWithRelations()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $response = $this->postJson('/api/clients', self::$CONSTDATACLIENT);
        $response->assertStatus(200)->assertJsonFragment(['legal_name' => 'Test Client']);
        $this->assertDatabaseHas('clients', ['registration_number' => 'REG-002']);
        $this->assertDatabaseHas('client_addresses', ['address' => 'Avenida Siempre Viva 742']);
        $this->assertDatabaseHas('client_phones', ['phone' => '612345678']);
        $this->assertDatabaseHas('client_emails', ['email' => 'updated@example.com']);
        $this->assertDatabaseHas('client_bank_accounts', ['account_number' => 'FR0987654321098765432109']);
    }

    public function testShowReturnsSpecificClient()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $client = Client::factory()->hasAddresses(1)->hasPhones(1)->hasEmails(1)->hasBankAccounts(1)->create();
        $response = $this->getJson("/api/clients/{$client->id}");
        $response->assertStatus(200)->assertJsonFragment(['id' => $client->id]);
    }

    public function testUpdateUpdatesClientAndRelations()
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $client = Client::factory()->hasAddresses(1)->hasPhones(1)->hasEmails(1)->hasBankAccounts(1)->create();

        $response = $this->putJson("/api/clients/{$client->id}", self::$CONSTDATACLIENT);
        $response->assertStatus(200)->assertJsonFragment(['legal_name' => 'Test Client']);
        $this->assertDatabaseHas('clients', ['registration_number' => 'REG-002']);
        $this->assertDatabaseHas('client_addresses', ['address' => 'Avenida Siempre Viva 742']);
        $this->assertDatabaseHas('client_phones', ['phone' => '612345678']);
        $this->assertDatabaseHas('client_emails', ['email' => 'updated@example.com']);
        $this->assertDatabaseHas('client_bank_accounts', ['account_number' => 'FR0987654321098765432109']);
    }
}
