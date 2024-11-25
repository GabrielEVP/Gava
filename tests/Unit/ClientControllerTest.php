<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    public function index_returns_clients_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        Client::factory()->count(3)->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/clients");

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function index_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();

        $response = $this->getJson("/api/companies/{$company->id}/clients");

        $response->assertStatus(403);
    }

    public function store_creates_new_client_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $clientData = Client::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/clients", $clientData);

        $response->assertStatus(201)
            ->assertJsonFragment($clientData);
        $this->assertDatabaseHas('clients', $clientData);
    }

    public function store_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $clientData = Client::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/clients", $clientData);

        $response->assertStatus(403);
    }

    public function show_returns_client_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $client = Client::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/clients/{$client->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($client->toArray());
    }

    public function show_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $client = Client::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/clients/{$client->id}");

        $response->assertStatus(403);
    }

    public function update_modifies_existing_client_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $client = Client::factory()->create(['company_id' => $company->id]);
        $updatedData = Client::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/clients/{$client->id}", $updatedData);

        $response->assertStatus(201)
            ->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('clients', $updatedData);
    }

    public function update_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $client = Client::factory()->create(['company_id' => $company->id]);
        $updatedData = Client::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/clients/{$client->id}", $updatedData);

        $response->assertStatus(403);
    }

    public function destroy_deletes_client_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $client = Client::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/clients/{$client->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => "Client With Id: {$client->id} Has Been Deleted"]);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }

    public function destroy_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $client = Client::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/clients/{$client->id}");

        $response->assertStatus(403);
    }
}
