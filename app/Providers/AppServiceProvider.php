<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Inertia\Inertia;

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
        JsonResource::withoutWrapping();
        Inertia::share([
            'locale' => function () {
                return app()->getLocale();
            },
            'language' => function () {
                return translations(
                    resource_path('lang/' . app()->getLocale() . '.json')
                );
            },
        ]);
    }
}
