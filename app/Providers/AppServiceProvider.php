<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            if($user) {
                $latestCount = $user->latestCount();
            } else {
                $latestCount = null;
            }
            
            $view->with('latestCount', $latestCount);
        });
    }
}
