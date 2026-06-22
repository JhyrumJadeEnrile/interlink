<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

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
        // I-share ang unread messages count sa layouts.sidebar blade view
        View::composer('layouts.sidebar', function ($view) {
            $unreadCount = 0;
            
            if (Auth::check()) {
                $unreadCount = Message::where('receiver_id', Auth::id())
                                      ->where('is_read', false)
                                      ->count();
            }
            
            $view->with('unreadMessageCount', $unreadCount);
        });
    }
}