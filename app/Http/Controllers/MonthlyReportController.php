<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Billing;

class MonthlyReportController extends Controller
{
    public function index(Request $request)
    {
        // Get the selected month from the request, default to current month
        $selectedMonth = $request->get('month', now()->format('Y-m'));

        // Fetch the billing data for the selected month, joining with clients table
        $billingData = Billing::with('client') // Eloquent relationship
            ->where('billing_date', 'like', $selectedMonth . '%')
            ->get(['id', 'billing_date', 'amount', 'payment_status', 'client_id']); // We need client_id to join

        // Map the client name to each bill
        $billingData->transform(function ($bill) {
            // Access the related client and add client name
            $bill->client_name = $bill->client ? $bill->client->name : 'Unknown Client'; // Safeguard if client is missing
            return $bill;
        });

        // Return the data to the Inertia view
        return Inertia::render('Monthlyreport', [
            'billingData' => $billingData,
            'selectedMonth' => $selectedMonth
        ]);
    }
}
