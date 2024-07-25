<?php

namespace Chernogolov\Mtm;

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

        if(is_dir(__DIR__ . '/Translations')) {
            $this->loadTranslationsFrom(__DIR__.'/Translations', 'mtm');
        }

        $this->publishes([
            __DIR__.'/Assets' => public_path('vendor/mtm'),
        ], 'public');
//
//        Gate::define('view-admin', function ($user) {
//            return in_array($user->id, [1]);
//        });
//
//        Gate::define('view-regs', function ($user) {
//            return RegsUsers::where([['user_id', '=', $user->id],['view', '=', 1]])->first();
//        });

        $resources = Resource::all();
        View::share('resources', $resources);

        Blade::component('mtm-layout', MtmLayout::class);
        Blade::componentNamespace('Chernogolov\\Mtm\\Components', 'mtmcom');


        include __DIR__.'/Routes/Routes.php';
    }
    public function register()
    {
        //
    }
}
