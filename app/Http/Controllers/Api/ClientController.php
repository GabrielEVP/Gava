<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    public function index(): JsonResponse
    {
        $clients = Client::all();
        return response()->json($clients, 200);
    }

    public function store(ClientRequest $request)
    {
        $client = Client::create($request->all());

        $addresses = $request->input('addresses', []);
        foreach ($addresses as $address) {
            $client->addresses()->create($address);
        }

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

        return response()->json($client->load(['addresses', 'phones', 'emails', 'bankAccounts']), 200);
    }

    public function show(string $id): JsonResponse
    {
        $client = Client::with(['phones', 'emails', 'bankAccounts'])->findOrFail($id);
        return response()->json($client, 200);
    }

    public function update(ClientRequest $request, string $id)
    {

        $client = Client::findOrFail($id);
        $client->update($request->all());

        $client->addresses()->delete();
        foreach ($request->input('addresses', []) as $address) {
            $client->addresses()->create($address);
        }

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

        return response()->json($client->load(['addresses', 'phones', 'emails', 'bankAccounts']), 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $client = Client::findOrFail($id);
        $client->addresses()->delete();
        $client->phones()->delete();
        $client->emails()->delete();
        $client->bankAccounts()->delete();
        $client->delete();

        return response()->json(["message" => "Client With Id: {$id} Has Been Deleted"], 200);
    }

    public function search(string $query): JsonResponse
    {
        $clients = Client::with(['phones', 'emails', 'bankAccounts'])
            ->where('legal_name', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($clients, 200);
    }
}
