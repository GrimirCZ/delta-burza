<?php

namespace App\Providers;

use App;
use App\Settings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Settings::class, function(){
            return Settings::make(storage_path('app/settings.json'));
        });

        if(config('app.env') === 'production'){
            URL::forceScheme('https');
        }
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        App::setLocale('cs');
        Schema::defaultStringLength(191);
        //
    }
}
