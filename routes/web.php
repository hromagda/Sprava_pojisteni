<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InsuredPersonController;
use App\Http\Controllers\InsuranceController;

// Domácí stránka
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Breeze dashboard – chráněno přihlášením a ověřením
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Breeze profilové routy – chráněno přihlášením
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============ TVÉ PŮVODNÍ ROUTY ============

// Resource routa pro správu pojištěnců
Route::resource('insuredPersons', InsuredPersonController::class);

// Routy pro pojištění konkrétního pojištěnce
Route::prefix('insured-persons/{insuredPersonId}/insurances')->group(function () {
    Route::get('create', [InsuranceController::class, 'create'])->name('insuredPersons.insurances.create');
    Route::post('/', [InsuranceController::class, 'store'])->name('insuredPersons.insurances.store');

    Route::get('{insuranceId}/edit', [InsuranceController::class, 'edit'])->name('insuredPersons.insurances.edit');
    Route::put('{insuranceId}', [InsuranceController::class, 'update'])->name('insuredPersons.insurances.update');

    Route::delete('{insuranceId}', [InsuranceController::class, 'destroy'])->name('insuredPersons.insurances.destroy');
});

// Zobrazení přehledu všech pojištění mimo prefix
Route::get('/insurances', [InsuranceController::class, 'index'])->name('insurances.index');

// Breeze routy (login, register, forgot password atd.)
require __DIR__.'/auth.php';
