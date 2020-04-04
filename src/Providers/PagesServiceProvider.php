<?php

declare(strict_types=1);

namespace Rinvex\Pages\Providers;

use Exception;
use Rinvex\Pages\Models\Page;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Rinvex\Pages\Console\Commands\MigrateCommand;
use Rinvex\Pages\Console\Commands\PublishCommand;
use Rinvex\Pages\Console\Commands\RollbackCommand;
use Rinvex\Pages\Http\Controllers\PagesController;

class PagesServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        MigrateCommand::class => 'command.rinvex.pages.migrate',
        PublishCommand::class => 'command.rinvex.pages.publish',
        RollbackCommand::class => 'command.rinvex.pages.rollback',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'rinvex.pages');

        // Bind eloquent models to IoC container
        $this->app->singleton('rinvex.pages.page', $pageModel = $this->app['config']['rinvex.pages.models.page']);
        $pageModel === Page::class || $this->app->alias('rinvex.pages.page', Page::class);

        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(Router $router): void
    {
        // Load resources
        $this->loadRoutes($router);

        // Publish Resources
        $this->publishesConfig('rinvex/pages');
        $this->publishesMigrations('rinvex/pages');
        ! $this->autoloadMigrations('rinvex/pages') || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }

    /**
     * Load the routes.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    protected function loadRoutes(Router $router): void
    {
        try {
            // Just check if we have DB connection! This is to avoid
            // exceptions on new projects before configuring database options
            DB::connection()->getPdo();

            if (config('rinvex.pages.register_routes') && ! $this->app->routesAreCached() && Schema::hasTable(config('rinvex.pages.tables.pages'))) {
                app('rinvex.pages.page')->where('is_active', true)->get()->groupBy('domain')->each(function ($pages, $domain) {
                    Route::domain($domain ?? domain())->group(function () use ($pages) {
                        $pages->each(function ($page) {
                            Route::get($page->uri)
                                 ->name($page->route)
                                 ->uses(PagesController::class)
                                 ->middleware($page->middleware ?? ['web'])
                                 ->where('locale', '[a-z]{2}');
                        });
                    });
                });
            }
        } catch (Exception $e) {
            // Be quite! Do not do or say anything!!
        }
    }
}
