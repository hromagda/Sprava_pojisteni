<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InsuredPersonController;
use App\Http\Controllers\InsuranceController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Resource routa
Route::resource('insuredPersons', InsuredPersonController::class);

// Routy pro pojištění konkrétního pojištěnce
Route::prefix('insured-persons/{insuredPersonId}/insurances')->group(function () {
    // Vytvoření nového pojištění pro pojištěnce
    Route::get('create', [InsuranceController::class, 'create'])->name('insuredPersons.insurances.create');
    Route::post('/', [InsuranceController::class, 'store'])->name('insuredPersons.insurances.store');

    // Editace pojištění pro pojištěnce
    Route::get('{insuranceId}/edit', [InsuranceController::class, 'edit'])->name('insuredPersons.insurances.edit');
    Route::put('{insuranceId}', [InsuranceController::class, 'update'])->name('insuredPersons.insurances.update');

    // Smazání pojištění pro pojištěnce
    Route::delete('{insuranceId}', [InsuranceController::class, 'destroy'])->name('insuredPersons.insurances.destroy');

});

// Zobrazení přehledu všech pojištění (včetně jména pojištěnce) mimo prefixu
Route::get('/insurances', [InsuranceController::class, 'index'])->name('insurances.index');









