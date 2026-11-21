<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class ViewServiceProvider extends ServiceProvider
{
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
