<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Company;
use Illuminate\Http\JsonResponse;

/**
 * Class ClientController
 *
 * Controller for handling client-related operations within a company.
 */
class ClientController extends Controller
{
    /**
     * Display a listing of the clients for the specified company.
     *
     * @param string $company_id The ID of the company.
     * @return JsonResponse
     */
    public function index(string $company_id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $clients = $company->clients->load(['phones', 'emails']);
            return response()->json($clients, 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Store a newly created client in the specified company.
     *
     * @param string $company_id The ID of the company.
     * @param ClientRequest $request The request object containing client data.
     * @return JsonResponse
     */
    public function store(string $company_id, ClientRequest $request): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $client = $company->clients()->create($request->all());

            $phones = $request->input('phones', []);
            foreach ($phones as $phone) {
                $client->phones()->create($phone);
            }

            $emails = $request->input('emails', []);
            foreach ($emails as $email) {
                $client->emails()->create($email);
            }

            return response()->json($client->load(['phones', 'emails']), 201);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Display the specified client of the specified company.
     *
     * @param string $company_id The ID of the company.
     * @param string $id The ID of the client.
     * @return JsonResponse
     */
    public function show(string $company_id, string $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $client = $company->clients()->with(['phones', 'emails'])->findOrFail($id);

            return response()->json($client, 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Update the specified client in the specified company.
     *
     * @param string $company_id The ID of the company.
     * @param ClientRequest $request The request object containing updated client data.
     * @param string $id The ID of the client.
     * @return JsonResponse
     */
    public function update(string $company_id, ClientRequest $request, string $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $client = $company->clients()->findOrFail($id);
            $client->update($request->all());

            $client->phones()->delete();
            foreach ($request->input('phones', []) as $phone) {
                $client->phones()->create($phone);
            }

            $client->emails()->delete();
            foreach ($request->input('emails', []) as $email) {
                $client->emails()->create($email);
            }

            return response()->json($client->load(['phones', 'emails']), 201);
        }
        return response()->json(['message' => 'You dont have access this Company'], 403);
    }

    /**
     * Remove the specified client from the specified company.
     *
     * @param string $company_id The ID of the company.
     * @param string $id The ID of the client.
     * @return JsonResponse
     */
    public function destroy(string $company_id, string $id): JsonResponse
    {
        $company = Company::findOrFail($company_id);

        if (auth()->user()->can('access', $company)) {
            $client = $company->clients()->findOrFail($id);
            $client->phones()->delete();
            $client->emails()->delete();
            $client->delete();
            return response()->json(["message" => "Client With Id: {$id} Has Been Deleted"], 200);
        }

        return response()->json(['message' => 'You dont have access this Company'], 403);
    }
}
