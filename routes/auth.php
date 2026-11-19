<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\ClientAuthController;
use Illuminate\Support\Facades\Route;

// --- ROUTES PUBLIQUES (Visiteurs non connectés) ---
Route::middleware('guest')->group(function () {

    // 1. Connexion classique (Email / Mot de passe) - Utilisée par l'Admin
 // Redirection automatique vers le login téléphone
    Route::get('login', function () {
        return redirect()->route('login.phone');
    })->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // 2. Connexion Client par Téléphone (OTP)
    Route::get('login/telephone', [ClientAuthController::class, 'showPhoneLogin'])->name('login.phone');
    Route::post('login/telephone', [ClientAuthController::class, 'sendCode'])->name('login.phone.send');
    Route::get('login/verification', [ClientAuthController::class, 'showVerify'])->name('login.phone.verify');
    Route::post('login/verification', [ClientAuthController::class, 'verifyCode'])->name('login.phone.verify.post');

    // 3. Connexions spécifiques (Admin / Équipe)
    Route::get('login/equipe', [AuthenticatedSessionController::class, 'createTeam'])->name('login.team');
    Route::get('login/admin', [AuthenticatedSessionController::class, 'createAdmin'])->name('login.admin');

    // 4. Inscription Client
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // 5. Mot de passe oublié
    Route::get('forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
});

// --- ROUTES PROTÉGÉES (Utilisateurs connectés) ---
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
