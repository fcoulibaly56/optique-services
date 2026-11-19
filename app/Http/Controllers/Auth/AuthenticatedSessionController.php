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

        // Logique de redirection selon le rôle
        $role = Auth::user()->role;

        if ($role === 'superadmin') {
            return redirect()->intended(route('superadmin.dashboard', absolute: false));
        }

        if (in_array($role, ['opticien', 'admin'])) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        // Par défaut, client
        return redirect()->intended(route('client.dashboard', absolute: false));
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
