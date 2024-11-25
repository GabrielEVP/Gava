<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\RecurringInvoice;
use App\Models\User;
use Tests\Feature\RecurringInvoiceLine;
use Tests\TestCase;

class RecurringInvoiceControllerTest extends TestCase
{
    public function index_returns_recurring_invoices_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        RecurringInvoice::factory()->count(3)->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/recurring-invoices");

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function index_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();

        $response = $this->getJson("/api/companies/{$company->id}/recurring-invoices");

        $response->assertStatus(403);
    }

    public function store_creates_new_recurring_invoice_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $invoiceData = RecurringInvoice::factory()->make()->toArray();
        $invoiceLinesData = RecurringInvoiceLine::factory()->count(2)->make()->toArray();
        $invoiceData['lines'] = $invoiceLinesData;

        $response = $this->postJson("/api/companies/{$company->id}/recurring-invoices", $invoiceData);

        $response->assertStatus(201)
            ->assertJsonFragment($invoiceData);
        $this->assertDatabaseHas('recurring_invoices', $invoiceData);
        foreach ($invoiceLinesData as $line) {
            $this->assertDatabaseHas('recurring_invoice_lines', $line);
        }
    }

    public function store_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $invoiceData = RecurringInvoice::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/recurring-invoices", $invoiceData);

        $response->assertStatus(403);
    }

    public function show_returns_recurring_invoice_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $invoice = RecurringInvoice::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/recurring-invoices/{$invoice->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($invoice->toArray());
    }

    public function show_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $invoice = RecurringInvoice::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/recurring-invoices/{$invoice->id}");

        $response->assertStatus(403);
    }

    public function update_modifies_existing_recurring_invoice_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $invoice = RecurringInvoice::factory()->create(['company_id' => $company->id]);
        $updatedData = RecurringInvoice::factory()->make()->toArray();
        $updatedInvoiceLinesData = RecurringInvoiceLine::factory()->count(2)->make()->toArray();
        $updatedData['lines'] = $updatedInvoiceLinesData;

        $response = $this->putJson("/api/companies/{$company->id}/recurring-invoices/{$invoice->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('recurring_invoices', $updatedData);
        foreach ($updatedInvoiceLinesData as $line) {
            $this->assertDatabaseHas('recurring_invoice_lines', $line);
        }
    }

    public function update_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $invoice = RecurringInvoice::factory()->create(['company_id' => $company->id]);
        $updatedData = RecurringInvoice::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/recurring-invoices/{$invoice->id}", $updatedData);

        $response->assertStatus(403);
    }

    public function destroy_deletes_recurring_invoice_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $invoice = RecurringInvoice::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/recurring-invoices/{$invoice->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => "RecurringInvoice deleted successfully"]);
        $this->assertDatabaseMissing('recurring_invoices', ['id' => $invoice->id]);
    }

    public function destroy_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $invoice = RecurringInvoice::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/recurring-invoices/{$invoice->id}");

        $response->assertStatus(403);
    }
}
