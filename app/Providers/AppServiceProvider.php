<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\ContactRequest;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Compteur de messages non lus (menus équipe et client)
        View::composer(['layouts.admin', 'layouts.client'], function ($view) {
            if (! Auth::check()) {
                return;
            }

            $user = Auth::user();

            if ($user->role === 'client' && $user->customer) {
                // Messages du staff non lus par ce client
                $unreadCount = Message::where('sender_role', 'staff')
                    ->whereHas('conversation', fn ($q) => $q->where('customer_id', $user->customer->id))
                    ->whereDoesntHave('reads', fn ($q) => $q->where('user_id', $user->id))
                    ->count();
            } else {
                // Messages des clients non lus par l'admin/opticien
                $unreadCount = Message::where('sender_role', 'client')
                    ->whereDoesntHave('reads', fn ($q) => $q->where('user_id', $user->id))
                    ->count();
            }

            $view->with('globalUnreadCount', $unreadCount);
        });

        // Pastilles du menu de l'espace équipe
        View::composer('layouts.admin', function ($view) {
            $view->with([
                'newContactsCount'         => ContactRequest::where('processed', false)->count(),
                'pendingAppointmentsCount' => Appointment::where('status', 'en_attente')->count(),
            ]);
        });
    }
}
