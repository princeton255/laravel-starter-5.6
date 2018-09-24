<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::routes();

        /**
         * Register global date serialization format
         */
        \Illuminate\Support\Carbon::serializeUsing(function ($carbon) {
            /** @var \Carbon\Carbon $carbon */
            return $carbon->toIso8601ZuluString();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
