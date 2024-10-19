<?php

namespace Chernogolov\Mtm;

use Chernogolov\Mtm\Models\Options;
use Chernogolov\Mtm\View\MtmLayout;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;
use Chernogolov\Mtm\Models\Resource;
use Illuminate\Support\Facades\View;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        // Implicitly grant "Super-Admin" role all permission checks using can()
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Super-Admin')) {
                return true;
            }
        });

        $this->publishes([
            __DIR__.'/../config/mtm.php' => config_path('mtm.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/../config/mtm.php', 'mtm'
        );

        if(is_dir(__DIR__ . '/Migrations')) {
            $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        }

        if(is_dir(__DIR__ . '/Views')) {
            $this->loadViewsFrom(__DIR__ . '/Views', 'mtm');
        }

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'mtm');
        $this->loadJsonTranslationsFrom(__DIR__.'/../lang');
        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/mtm'),
        ]);

        $this->publishes([
            __DIR__.'/Assets' => public_path('vendor/mtm'),
            __DIR__.'/../lang' => $this->app->langPath('vendor/mtm'),
        ], 'public');
//
//        Gate::define('view-admin', function ($user) {
//            return in_array($user->id, [1]);
//        });
//
//        Gate::define('view-regs', function ($user) {
//            return RegsUsers::where([['user_id', '=', $user->id],['view', '=', 1]])->first();
//        });

        

        try {
            $resources = Resource::orderBy('ordering')->get();
            View::share('resources', $resources);
        } catch (\Exception $e) {
        }
        
        try {
            $options = Options::getOptions();
            View::share('options', $options);
        } catch (\Exception $e) {
        }

        Blade::component('mtm-layout', MtmLayout::class);
        Blade::componentNamespace('Chernogolov\\Mtm\\Components', 'mtmcom');


        include __DIR__.'/Routes/Routes.php';
    }
    public function register()
    {
        //
    }
}
