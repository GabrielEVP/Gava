<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\JsonResponse;

/**
 * Class CompanyController
 *
 * Controller for handling company-related operations.
 */
class CompanyController extends Controller
{
    /**
     * Display a listing of the companies for the authenticated user.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $companies = Company::where('user_id', auth()->id())->get();
        return response()->json($companies, 200);
    }

    /**
     * Store a newly created company in storage.
     *
     * @param CompanyRequest $request The request object containing company data.
     * @return JsonResponse
     */
    public function store(CompanyRequest $request): JsonResponse
    {
        $company = Company::create(array_merge(
            $request->all(),
            ['user_id' => auth()->id()]
        ));

        return response()->json($company, 201);
    }

    /**
     * Display the specified company.
     *
     * @param string $id The ID of the company.
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $company = Company::findOrFail($id);
        return response()->json($company, 200);
    }

    /**
     * Update the specified company in storage.
     *
     * @param CompanyRequest $request The request object containing updated company data.
     * @param string $id The ID of the company.
     * @return JsonResponse
     */
    public function update(CompanyRequest $request, string $id): JsonResponse
    {
        $company = Company::findOrFail($id);
        $company->update($request->all());

        return response()->json($company, 200);
    }

    /**
     * Remove the specified company from storage.
     *
     * @param string $id The ID of the company.
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json(["message" => "Company With Id: {$id} Has Been Deleted"], 200);
    }
}
