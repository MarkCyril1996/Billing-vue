<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Billing;  // Assuming you have a Billing model
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the necessary data from the database
        $totalClients = Client::count();  // Count the number of clients
        $totalBilling = $this->getTotalBilling(); // Count the total number of billing records
        $pendingPayments = $this->getPendingPaymentsCount(); // Fetch the count of pending payments

        // Pass data to Inertia view
        return Inertia::render('Dashboard', [
            'totalClients' => $totalClients,
            'totalBilling' => $totalBilling,  // Pass the total billing count
            'pendingPayments' => $pendingPayments,
        ]);
    }

    // Get the total count of billing records
    private function getTotalBilling()
    {
        // Count all records in the billings table
        return Billing::count();  // Adjust as per your actual logic
    }

    // Get the count of pending payments (if applicable)
    private function getPendingPaymentsCount()
    {
        return Billing::where('payment_status', 'pending')->count();  // Adjust as per your actual logic
    }
}
