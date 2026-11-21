<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
       public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    [$home, $prefix] = match (Auth::user()->role) {
        'superadmin'        => [route('superadmin.dashboard', absolute: false), '/superadmin'],
        'opticien', 'admin' => [route('admin.dashboard', absolute: false), '/admin'],
        default             => [route('client.dashboard', absolute: false), '/mon-espace'],
    };

    // La page demandée avant la connexion n'est réutilisée que si elle est dans l'espace du rôle
    $intended = $request->session()->pull('url.intended');
    $path = $intended ? (parse_url($intended, PHP_URL_PATH) ?: '') : '';
    $inOwnArea = $path === $prefix || str_starts_with($path, $prefix . '/');

    return redirect()->to($inOwnArea ? $intended : $home);
}

        public function createTeam(): View
    {
        return view('auth.login-team'); // La maquette "Espace équipe"
    }

    public function createAdmin(): View
    {
        return view('auth.login-admin'); // La maquette "Espace administration"
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
