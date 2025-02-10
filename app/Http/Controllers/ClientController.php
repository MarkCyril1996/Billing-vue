<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Fetch all clients for the web (returns JSON for Vue.js)
    public function index()
    {
        return response()->json(Client::all());
    }

    // Store a new client (returns JSON for Vue.js)
    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'meter_code' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone_number' => 'required|string|max:20',
            'status' => 'required|in:Active,Inactive',
        ]);

        try {
            // Create the new client record
            $client = Client::create([
                'name' => $validatedData['name'],
                'address' => $validatedData['address'],
                'meter_code' => $validatedData['meter_code'],
                'email' => $validatedData['email'],
                'phone_number' => $validatedData['phone_number'],
                'status' => $validatedData['status'],
            ]);

            // Return the new client data as JSON
            return response()->json($client, 201);  // Return a 201 Created status code
        } catch (\Exception $e) {
            // Handle any errors during client creation
            return response()->json(['error' => 'Failed to add client.'], 500);
        }
    }

    // Delete a client by ID
    public function destroy($id)
    {
        // Find the client by ID
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        // Delete the client record
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully'], 200);
    }

    // Update an existing client
    public function update(Request $request, $id)
    {
        // Find the client by ID, or fail with a 404 error
        $client = Client::findOrFail($id);

        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'meter_code' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        // Update the client with the validated data
        $client->update($validatedData);

        // Return the updated client as a response
        return response()->json($client);
    }
}
