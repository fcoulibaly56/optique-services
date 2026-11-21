<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = $request->user();

        // Désactivé = explicitement à 0/false. Une valeur NULL n'est jamais un blocage.
        $deactivated = $user && $user->is_active !== null && ! $user->is_active;

        if ($deactivated) {
            $loginRoute = in_array($user->role, ['opticien', 'admin'], true) ? 'login.team' : 'login.phone';

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route($loginRoute)
                ->withErrors(['email' => 'Ce compte a été désactivé. Contactez le responsable du magasin.']);
        }

        abort_unless($user && in_array($user->role, $roles, true), 403);

        return $next($request);
    }
}
