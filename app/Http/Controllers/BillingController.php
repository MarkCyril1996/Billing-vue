<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BillingController extends Controller
{
  
    public function index()
    {
        $billings = Billing::all(); // Fetch all billing records
        return response()->json($billings); // Return as JSON
    }

    public function getBilling()
    {
        // Fetch billings along with the client name for API response
        $billing = Billing::with('client:id,name') // Eager load only the client ID and name
            ->select('id', 'client_id', 'amount', 'due_date', 'payment_status', 'meter_cubic_usage', 'billing_cycle', 'billing_date', 'due_date')
            ->get();

        return response()->json($billing);
    }

    /**
     * Store a new billing record.
     */
    public function store(Request $request)
    {
        // Add custom validation messages
        $validated = $request->validate([
            'clientId' => 'required|exists:clients,id',
            'meterCubicUsage' => 'required|numeric',
            'amount' => 'required|numeric',
            'paymentStatus' => 'required|string|in:Pending,Paid',
            'billingCycle' => 'required|string|in:Monthly,Quarterly',
            'billingDate' => 'required|date',
            'dueDate' => 'required|date|after_or_equal:billingDate', // Ensure dueDate is after billingDate
        ], [
            'dueDate.after_or_equal' => 'The due date must be equal to or after the billing date.',
        ]);

        // Create a new Billing record
        $billing = Billing::create([
            'client_id' => $validated['clientId'],
            'meter_cubic_usage' => $validated['meterCubicUsage'],
            'amount' => $validated['amount'],
            'payment_status' => $validated['paymentStatus'],
            'billing_cycle' => $validated['billingCycle'],
            'billing_date' => $validated['billingDate'],
            'due_date' => $validated['dueDate'],
        ]);

        // Fetch the newly created billing record along with the associated client
        $billing = Billing::with('client')->find($billing->id);

        return response()->json($billing, 201); // Return the new billing record with client data
    }

    public function update(Request $request, $id)
    {
        $billing = Billing::findOrFail($id);

        $validated = $request->validate([
            'clientId' => 'required|exists:clients,id',  // Assuming you have a Client model
            'amount' => 'required|numeric',
            'paymentStatus' => 'required|string',
            'billingCycle' => 'required|string',
            'billingDate' => 'required|date',
            'dueDate' => 'required|date',
            'meterCubicUsage' => 'required|numeric',
        ]);

        $billing->update([
            'client_id' => $validated['clientId'],
            'amount' => $validated['amount'],
            'payment_status' => $validated['paymentStatus'],
            'billing_cycle' => $validated['billingCycle'],
            'billing_date' => $validated['billingDate'],
            'due_date' => $validated['dueDate'],
            'meter_cubic_usage' => $validated['meterCubicUsage'],
        ]);

        return response()->json($billing);
    }

    public function destroy($id)
    {
        
        $billing = Billing::find($id);

        if (!$billing) {
            return response()->json(['message' => 'Billing not found'], 404);
        }

       
        $billing->delete();

        return response()->json(['message' => 'Billing deleted successfully'], 200);
    }

   
    public function getClients()
    {
        // You might want to paginate if you have a lot of clients
        $clients = Client::all();
        return response()->json($clients);
    }

    
}
