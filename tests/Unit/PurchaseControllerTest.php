<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Purchase;
use App\Models\User;
use Tests\Feature\PurchaseDueDate;
use Tests\Feature\PurchaseLine;
use Tests\Feature\PurchasePayment;
use Tests\TestCase;

class PurchaseControllerTest extends TestCase
{
    public function index_returns_purchases_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        Purchase::factory()->count(3)->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/purchases");

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function index_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();

        $response = $this->getJson("/api/companies/{$company->id}/purchases");

        $response->assertStatus(403);
    }

    public function store_creates_new_purchase_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $purchaseData = Purchase::factory()->make()->toArray();
        $purchaseLinesData = PurchaseLine::factory()->count(2)->make()->toArray();
        $purchaseDueDatesData = PurchaseDueDate::factory()->count(2)->make()->toArray();
        $purchasePaymentsData = PurchasePayment::factory()->count(2)->make()->toArray();
        $purchaseData['purchase_lines'] = $purchaseLinesData;
        $purchaseData['purchase_due_dates'] = $purchaseDueDatesData;
        $purchaseData['purchase_payments'] = $purchasePaymentsData;

        $response = $this->postJson("/api/companies/{$company->id}/purchases", $purchaseData);

        $response->assertStatus(201)
            ->assertJsonFragment($purchaseData);
        $this->assertDatabaseHas('purchases', $purchaseData);
        foreach ($purchaseLinesData as $line) {
            $this->assertDatabaseHas('purchase_lines', $line);
        }
        foreach ($purchaseDueDatesData as $dueDate) {
            $this->assertDatabaseHas('purchase_due_dates', $dueDate);
        }
        foreach ($purchasePaymentsData as $payment) {
            $this->assertDatabaseHas('purchase_payments', $payment);
        }
    }

    public function store_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $purchaseData = Purchase::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/purchases", $purchaseData);

        $response->assertStatus(403);
    }

    public function show_returns_purchase_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $purchase = Purchase::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/purchases/{$purchase->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($purchase->toArray());
    }

    public function show_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $purchase = Purchase::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/purchases/{$purchase->id}");

        $response->assertStatus(403);
    }

    public function update_modifies_existing_purchase_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $purchase = Purchase::factory()->create(['company_id' => $company->id]);
        $updatedData = Purchase::factory()->make()->toArray();
        $updatedPurchaseLinesData = PurchaseLine::factory()->count(2)->make()->toArray();
        $updatedPurchaseDueDatesData = PurchaseDueDate::factory()->count(2)->make()->toArray();
        $updatedPurchasePaymentsData = PurchasePayment::factory()->count(2)->make()->toArray();
        $updatedData['purchase_lines'] = $updatedPurchaseLinesData;
        $updatedData['purchase_due_dates'] = $updatedPurchaseDueDatesData;
        $updatedData['purchase_payments'] = $updatedPurchasePaymentsData;

        $response = $this->putJson("/api/companies/{$company->id}/purchases/{$purchase->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('purchases', $updatedData);
        foreach ($updatedPurchaseLinesData as $line) {
            $this->assertDatabaseHas('purchase_lines', $line);
        }
        foreach ($updatedPurchaseDueDatesData as $dueDate) {
            $this->assertDatabaseHas('purchase_due_dates', $dueDate);
        }
        foreach ($updatedPurchasePaymentsData as $payment) {
            $this->assertDatabaseHas('purchase_payments', $payment);
        }
    }

    public function update_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $purchase = Purchase::factory()->create(['company_id' => $company->id]);
        $updatedData = Purchase::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/purchases/{$purchase->id}", $updatedData);

        $response->assertStatus(403);
    }

    public function destroy_deletes_purchase_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $purchase = Purchase::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/purchases/{$purchase->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => "purchase With Id: {$purchase->id} Has Been Deleted"]);
        $this->assertDatabaseMissing('purchases', ['id' => $purchase->id]);
    }

    public function destroy_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $purchase = Purchase::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/purchases/{$purchase->id}");

        $response->assertStatus(403);
    }
}
