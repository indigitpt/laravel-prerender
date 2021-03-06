<?php

namespace Indigit\LaravelPrerender;

use App;
use GuzzleHttp\Client;
use Indigit\LaravelPrerender\Http\Middleware\PrerenderMiddleware;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Support\ServiceProvider;

class LaravelPrerenderServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $package = 'indigit/laravel-prerender';

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/prerender.php' => config_path('prerender.php')
        ], 'config');

        if ($this->app['config']->get('prerender.enable')) {
            $kernel = $this->app['Illuminate\Contracts\Http\Kernel'];
            $kernel->pushMiddleware(PrerenderMiddleware::class);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/prerender.php', 'prerender');
    }

}