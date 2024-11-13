<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseTypeRequest;
use App\Models\Company;
use App\Models\ExpenseType;
use Illuminate\Http\JsonResponse;

class ExpenseTypeController extends Controller
{
    /**
     * Display a listing of the expense types for a specific company.
     *
     * @param int $company_id The ID of the company.
     * @return JsonResponse
     */
    public function index(int $company_id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $expenseTypes = $company->expenseTypes;
            return response()->json($expenseTypes, 200);
        }

        return response()->json(['message' => 'You dont have access to this Company'], 403);
    }

    /**
     * Store a newly created expense type in storage.
     *
     * @param int $company_id The ID of the company.
     * @param ExpenseTypeRequest $request The request object containing the expense type data.
     * @return JsonResponse
     */
    public function store(int $company_id, ExpenseTypeRequest $request): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $expenseType = ExpenseType::create($request->all());
            return response()->json($expenseType, 201);
        }

        return response()->json(['message' => 'You don\'t have access to this Company'], 403);
    }

    /**
     * Display the specified expense type.
     *
     * @param int $company_id The ID of the company.
     * @param int $id The ID of the expense type.
     * @return JsonResponse
     */
    public function show(int $company_id, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $expenseType = ExpenseType::where('company_id', $company_id)->findOrFail($id);
            return response()->json($expenseType, 200);
        }

        return response()->json(['message' => 'You dont have access to this Company'], 403);
    }

    /**
     * Update the specified expense type in storage.
     *
     * @param int $company_id The ID of the company.
     * @param ExpenseTypeRequest $request The request object containing the updated expense type data.
     * @param int $id The ID of the expense type.
     * @return JsonResponse
     */
    public function update(int $company_id, ExpenseTypeRequest $request, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $expenseType = ExpenseType::findOrFail($id);
            $expenseType->update($request->all());
            return response()->json($expenseType, 200);
        }

        return response()->json(['message' => 'You dont have access to this Company'], 403);
    }

    /**
     * Remove the specified expense type from storage.
     *
     * @param int $company_id The ID of the company.
     * @param int $id The ID of the expense type.
     * @return JsonResponse
     */
    public function destroy(int $company_id, int $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $expenseType = ExpenseType::findOrFail($id);
            $expenseType->delete();
            return response()->json(['message' => 'Expense Type deleted successfully'], 200);
        }
        return response()->json(['message' => 'You don\'t have access to this Company'], 403);
    }
}
