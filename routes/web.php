<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\MonthlyReportController;




Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/clientlist', function () {
    return Inertia::render('ClientList');  
})->middleware(['auth']); 

Route::get('/clientbilling', function () {
    return Inertia::render('ClientBilling');
})->middleware(['auth']); 

Route::get('/clients', [ClientController::class, 'index']);
Route::post('/clients', [ClientController::class, 'store']);
Route::put('/clients/{id}', [ClientController::class, 'update']);
Route::delete('/clients/{id}', [ClientController::class, 'destroy']);

Route::get('/billings', [BillingController::class, 'index']); 
Route::post('/billings', [BillingController::class, 'store']);  
Route::delete('/billings/{id}', [BillingController::class, 'destroy']); 
Route::put('/billings/{id}', [BillingController::class, 'update']);

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/monthlyreport', [MonthlyReportController::class, 'index']);