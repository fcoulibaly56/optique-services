<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Appointment;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\ContactRequest;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
     public function boot(): void
{
    View::composer(['layouts.admin', 'layouts.client'], function ($view) {
            if (!Auth::check()) return;

            $user = Auth::user();
            $unreadCount = 0;

            if ($user->role === 'client' && $user->customer) {
                // Compter les messages du staff non lus par ce client
                $unreadCount = Message::where('sender_role', 'staff')
                    ->whereHas('conversation', function($q) use ($user) {
                        $q->where('customer_id', $user->customer->id);
                    })
                    ->whereDoesntHave('reads', function($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })->count();
            } else {
                // Compter les messages des clients non lus par l'admin/opticien
                $unreadCount = Message::where('sender_role', 'client')
                    ->whereDoesntHave('reads', function($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })->count();
            }

            $view->with('globalUnreadCount', $unreadCount);
        });
}
}
    // Compteurs affichés dans le menu de l'espace équipe
    View::composer('layouts.admin', function ($view) {
        $view->with([
            'newContactsCount'         => ContactRequest::where('processed', false)->count(),
            'pendingAppointmentsCount' => Appointment::where('status', 'en_attente')->count(),
        ]);
    });

