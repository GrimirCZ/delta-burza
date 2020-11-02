<?php

namespace App\Providers;

use App;
use App\Settings;
use Illuminate\Support\Facades\Blade;
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

        if(config('app.env') !== 'development'){
            $this->app['request']->server->set('HTTPS', true);
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
        Blade::setEchoFormat('e(utf8_encode(%s))');
        Schema::defaultStringLength(191);
        //
    }
}
