<?php

declare(strict_types=1);

namespace Rinvex\Pages\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Rinvex\Pages\Contracts\PageContract;
use Rinvex\Pages\Console\Commands\MigrateCommand;
use Rinvex\Pages\Http\Controllers\PagesController;

class PagesServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        MigrateCommand::class => 'command.rinvex.pages.migrate',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'rinvex.pages');

        // Bind eloquent models to IoC container
        $this->app->singleton('rinvex.pages.page', function ($app) {
            return new $app['config']['rinvex.pages.models.page']();
        });
        $this->app->alias('rinvex.pages.page', PageContract::class);

        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
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
        if (config('rinvex.pages.register_routes') && ! $this->app->routesAreCached() && Schema::hasTable(config('rinvex.pages.tables.pages'))) {
            app('rinvex.pages.page')->active()->each(function ($page) use ($router) {
                $router->get($page->uri)
                       ->name($page->slug)
                       ->uses(PagesController::class)
                       ->middleware($page->middleware ?? 'web')
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

    /**
     * Register console commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        // Register artisan commands
        foreach ($this->commands as $key => $value) {
            $this->app->singleton($value, function ($app) use ($key) {
                return new $key();
            });
        }

        $this->commands(array_values($this->commands));
    }
}
