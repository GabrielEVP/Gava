<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\User;
use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    public function index_returns_invoices_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        Invoice::factory()->count(3)->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/invoices");

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function index_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();

        $response = $this->getJson("/api/companies/{$company->id}/invoices");

        $response->assertStatus(403);
    }

    public function store_creates_new_invoice_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $invoiceData = Invoice::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/invoices", $invoiceData);

        $response->assertStatus(201)
            ->assertJsonFragment($invoiceData);
        $this->assertDatabaseHas('invoices', $invoiceData);
    }

    public function store_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $invoiceData = Invoice::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/invoices", $invoiceData);

        $response->assertStatus(403);
    }

    public function show_returns_invoice_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $invoice = Invoice::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/invoices/{$invoice->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($invoice->toArray());
    }

    public function show_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $invoice = Invoice::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/invoices/{$invoice->id}");

        $response->assertStatus(403);
    }

    public function update_modifies_existing_invoice_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $invoice = Invoice::factory()->create(['company_id' => $company->id]);
        $updatedData = Invoice::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/invoices/{$invoice->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('invoices', $updatedData);
    }

    public function update_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $invoice = Invoice::factory()->create(['company_id' => $company->id]);
        $updatedData = Invoice::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/invoices/{$invoice->id}", $updatedData);

        $response->assertStatus(403);
    }

    public function destroy_deletes_invoice_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $invoice = Invoice::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/invoices/{$invoice->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => "Invoice With Id: {$invoice->id} Has Been Deleted"]);
        $this->assertDatabaseMissing('invoices', ['id' => $invoice->id]);
    }

    public function destroy_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $invoice = Invoice::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/invoices/{$invoice->id}");

        $response->assertStatus(403);
    }
}
