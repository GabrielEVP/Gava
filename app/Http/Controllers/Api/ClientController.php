<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;

/**
 * Class ClientController
 *
 * Controller for handling client-related operations within a company.
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;

/**
 * Class ClientController
 *
 * Controller for handling client-related operations.
 */
class ClientController extends Controller
{
    /**
     * Display a listing of the clients.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $clients = Client::all(); // Ya no se filtra por company_id
        return response()->json($clients, 200);
    }

    /**
     * Store a newly created client in storage.
     *
     * @param ClientRequest $request The request object containing client data.
     * @return JsonResponse
     */
    public function store(ClientRequest $request): JsonResponse
    {
        // Elimina la dependencia de Company
        $client = Client::create($request->all());

        $phones = $request->input('phones', []);
        foreach ($phones as $phone) {
            $client->phones()->create($phone);
        }

        $emails = $request->input('emails', []);
        foreach ($emails as $email) {
            $client->emails()->create($email);
        }

        $bankAccounts = $request->input('bank_accounts', []);
        foreach ($bankAccounts as $bankAccount) {
            $client->bankAccounts()->create($bankAccount);
        }

        return response()->json($client->load(['phones', 'emails', 'bankAccounts']), 201);
    }

    /**
     * Display the specified client.
     *
     * @param string $id The ID of the client.
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $client = Client::with(['phones', 'emails', 'bankAccounts'])->findOrFail($id);
        return response()->json($client, 200);
    }

    /**
     * Update the specified client in storage.
     *
     * @param ClientRequest $request The request object containing updated client data.
     * @param string $id The ID of the client.
     * @return JsonResponse
     */
    public function update(ClientRequest $request, string $id): JsonResponse
    {
        $client = Client::findOrFail($id);
        $client->update($request->all());

        $client->phones()->delete();
        foreach ($request->input('phones', []) as $phone) {
            $client->phones()->create($phone);
        }

        $client->emails()->delete();
        foreach ($request->input('emails', []) as $email) {
            $client->emails()->create($email);
        }

        $client->bankAccounts()->delete();
        foreach ($request->input('bank_accounts', []) as $bankAccount) {
            $client->bankAccounts()->create($bankAccount);
        }

        return response()->json($client->load(['phones', 'emails', 'bankAccounts']), 200);
    }

    /**
     * Remove the specified client from storage.
     *
     * @param string $id The ID of the client.
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $client = Client::findOrFail($id);
        $client->phones()->delete();
        $client->emails()->delete();
        $client->bankAccounts()->delete();
        $client->delete();

        return response()->json(["message" => "Client With Id: {$id} Has Been Deleted"], 200);
    }

    /**
     * Search for clients based on a query string.
     *
     * @param string $query The search query.
     * @return JsonResponse
     */
    public function search(string $query): JsonResponse
    {
        $clients = Client::with(['phones', 'emails', 'bankAccounts'])
            ->where('legal_name', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($clients, 200);
    }
}
