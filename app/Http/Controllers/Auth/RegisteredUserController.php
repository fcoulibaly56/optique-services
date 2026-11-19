<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
       public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'max:20', 'unique:'.User::class],
        'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // 1. On sépare le nom et le prénom
    $nameParts = explode(' ', $request->name, 2);
    $firstName = $nameParts[0];
    $lastName = $nameParts[1] ?? '';

    // 2. Création du User
    $user = User::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email ?? $request->phone . '@optique.local',
        'password' => Hash::make($request->password),
        'role' => 'client',
    ]);

    // 3. Création du Customer lié
    $user->customer()->create([
        'first_name' => $firstName,
        'last_name' => $lastName,
        'phone' => $request->phone,
        'email' => $request->email,
        'contact_preference' => 'email',
    ]);

    event(new Registered($user));
    Auth::login($user);

    return redirect(route('client.dashboard', absolute: false));
}
}
