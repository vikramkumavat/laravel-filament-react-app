<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!$this->app->environment('procuction') && config('app.asset_url')) {
            URL::forceRootUrl(config('app.asset_url'));
        }

        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(300)->by($request->user()?->id ?: $request->ip());
        });

        Model::unguard();

        view()->composer('*', function ($view) {
            $view->with('auctionConfig', [
                'APP_URL' => config('app.url'),
                'NOTIFICATION_MIN' => env('NOTIFICATION_MIN'),
            ]);
        });
    }
}
