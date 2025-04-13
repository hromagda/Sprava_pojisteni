<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InsuredPersonController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

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

    // Admin sekce pro správu uživatelů
    Route::middleware(['auth', 'role:admin', 'permission:edit users'])->group(function () {
        Route::resource('users', UserController::class)->except(['show']); // Přidání nového uživatele
    });
});
// Routy pro insuredPersons

Route::resource('insuredPersons', InsuredPersonController::class);


Route::middleware(['auth'])->group(function () {
    Route::prefix('insuredPersons/{insuredPersonId}/insurances')->group(function () {
        Route::get('create', [InsuranceController::class, 'create'])->name('insuredPersons.insurances.create');
        Route::post('/', [InsuranceController::class, 'store'])->name('insuredPersons.insurances.store');
        Route::get('{insuranceId}/edit', [InsuranceController::class, 'edit'])->name('insuredPersons.insurances.edit');
        Route::put('{insuranceId}', [InsuranceController::class, 'update'])->name('insuredPersons.insurances.update');
        Route::delete('{insuranceId}', [InsuranceController::class, 'destroy'])->name('insuredPersons.insurances.destroy');

        // Archivace a obnova – pouze pro admina a agenta
        Route::middleware('role:admin|agent')->group(function () {
            Route::put('{insuranceId}/archive', [InsuranceController::class, 'archive'])->name('insuredPersons.insurances.archive');
            Route::put('{insuranceId}/restore', [InsuranceController::class, 'restore'])->name('insuredPersons.insurances.restore');
        });
    });
});


// Přehled pojištění – pro viewer, agent i admin
Route::middleware(['auth', 'role:viewer|agent|admin'])->group(function () {
    Route::get('/insurances', [InsuranceController::class, 'index'])->name('insurances.index'); // Přehled pojištění
});

//REPORTY
Route::middleware(['auth', 'role:agent|admin'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/csv', [ReportController::class, 'exportCsv'])->name('reports.export.csv');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
});

// Breeze routy (login, register, forgot password atd.)
require __DIR__ . '/auth.php';
