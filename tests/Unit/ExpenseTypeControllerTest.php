<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\ExpenseType;
use App\Models\User;
use Tests\TestCase;

class ExpenseTypeControllerTest extends TestCase
{
    public function index_returns_expense_types_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        ExpenseType::factory()->count(3)->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/expense-types");

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function index_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();

        $response = $this->getJson("/api/companies/{$company->id}/expense-types");

        $response->assertStatus(403);
    }

    public function store_creates_new_expense_type_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $expenseTypeData = ExpenseType::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/expense-types", $expenseTypeData);

        $response->assertStatus(201)
            ->assertJsonFragment($expenseTypeData);
        $this->assertDatabaseHas('expense_types', $expenseTypeData);
    }

    public function store_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $expenseTypeData = ExpenseType::factory()->make()->toArray();

        $response = $this->postJson("/api/companies/{$company->id}/expense-types", $expenseTypeData);

        $response->assertStatus(403);
    }

    public function show_returns_expense_type_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $expenseType = ExpenseType::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/expense-types/{$expenseType->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($expenseType->toArray());
    }

    public function show_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $expenseType = ExpenseType::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson("/api/companies/{$company->id}/expense-types/{$expenseType->id}");

        $response->assertStatus(403);
    }

    public function update_modifies_existing_expense_type_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $expenseType = ExpenseType::factory()->create(['company_id' => $company->id]);
        $updatedData = ExpenseType::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/expense-types/{$expenseType->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('expense_types', $updatedData);
    }

    public function update_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $expenseType = ExpenseType::factory()->create(['company_id' => $company->id]);
        $updatedData = ExpenseType::factory()->make()->toArray();

        $response = $this->putJson("/api/companies/{$company->id}/expense-types/{$expenseType->id}", $updatedData);

        $response->assertStatus(403);
    }

    public function destroy_deletes_expense_type_by_id_for_authenticated_user_with_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create(['user_id' => $user->id]);
        $expenseType = ExpenseType::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/expense-types/{$expenseType->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Expense Type deleted successfully']);
        $this->assertDatabaseMissing('expense_types', ['id' => $expenseType->id]);
    }

    public function destroy_returns_403_for_user_without_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()->create();
        $expenseType = ExpenseType::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}/expense-types/{$expenseType->id}");

        $response->assertStatus(403);
    }
}
