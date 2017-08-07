<?php

declare(strict_types=1);

namespace Rinvex\Pages\Providers;

use Rinvex\Pages\Models\Page;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Rinvex\Pages\Http\Controllers\PagesController;

class PagesServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'rinvex.pages');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Load resources
        $this->loadRoutes($router);
        ! $this->app->runningInConsole() || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishResources();
    }

    /**
     * Load the routes.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    protected function loadRoutes(Router $router)
    {
        if (config('rinvex.pages.register_routes') && ! $this->app->routesAreCached()) {
            Page::active()->each(function ($page) use ($router) {
                $router->get($page->uri)
                       ->name($page->slug)
                       ->uses(PagesController::class)
                       ->middleware($page->middleware ?? [])
                       ->domain($page->domain ?? null);
            });
        }
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    protected function publishResources()
    {
        $this->publishes([realpath(__DIR__.'/../../config/config.php') => config_path('rinvex.pages.php')], 'rinvex-pages-config');
        $this->publishes([realpath(__DIR__.'/../../database/migrations') => database_path('migrations')], 'rinvex-pages-migrations');
    }
}
