<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InsuredPersonController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\UserController;

use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Middlewares\PermissionMiddleware;

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

    // Admin sekce – pouze pro adminy
    Route::middleware(['auth', 'role:admin', 'permission:edit users'])->resource('users', UserController::class)->only(['index', 'edit', 'update']);
    });

// ============ PŮVODNÍ ROUTY ============

// Admin+Agent sekce pro správu pojištěnců
    Route::middleware(['auth', 'role:admin|agent'])->group(function () {
        Route::resource('insuredPersons', InsuredPersonController::class);

        Route::prefix('insured-persons/{insuredPersonId}/insurances')->group(function () {
            Route::get('create', [InsuranceController::class, 'create'])->name('insuredPersons.insurances.create');
            Route::post('/', [InsuranceController::class, 'store'])->name('insuredPersons.insurances.store');

            Route::get('{insuranceId}/edit', [InsuranceController::class, 'edit'])->name('insuredPersons.insurances.edit');
            Route::put('{insuranceId}', [InsuranceController::class, 'update'])->name('insuredPersons.insurances.update');
            Route::delete('{insuranceId}', [InsuranceController::class, 'destroy'])->name('insuredPersons.insurances.destroy');
        });
    });
// Viewer – může pouze prohlížet pojištění
    Route::middleware(['auth', 'role:viewer'])->group(function () {
        Route::get('/insurances', [InsuranceController::class, 'index'])->name('insurances.index');
    });

// Breeze routy (login, register, forgot password atd.)
    require __DIR__ . '/auth.php';

