<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $companies = Company::where('user_id', auth()->id())->get();
        return response()->json($companies, 200);
    }

    public function store(CompanyRequest $request): \Illuminate\Http\JsonResponse
    {
        $company = Company::create(array_merge(
            $request->all(),
            ['user_id' => auth()->id()]
        ));

        return response()->json($company, 201);
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $company = Company::findOrFail($id);
        return response()->json($company, 200);
    }

    public function update(CompanyRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        $company = Company::findOrFail($id);
        $company->update($request->all());

        return response()->json($company, 200);
    }

    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json(["message" => "Company With Id: {$id} Has Been Deleted"], 200);    }
 }
