<?php

namespace Biginvn\History;

use Biginvn\History\Events\CreatedHistory;
use Biginvn\History\Events\SaveLogHistory;
use Illuminate\Support\ServiceProvider;

class HistoryServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'biginvn/history');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->app->booted(function () {
            foreach ([
                         CreatedHistory::class => config('biginvn.history.history.event_handler.created'),
                         SaveLogHistory::class => config('biginvn.history.history.event_handler.store'),
                     ] as $event => $eventHandler) {
                if ($eventHandler && class_exists($eventHandler)) {
                    $this
                        ->app['events']
                        ->listen(
                            $event,
                            $eventHandler
                        );
                }
            }
        });
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/history.php' => config_path('biginvn/history/history.php'),
        ], 'biginvn');

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'biginvn');

        // Publishing the translation files.
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/biginvn/history'),
        ], 'biginvn');

        // Registering package commands.
        $this->commands([]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/history.php', 'biginvn.history.history');

        // Register the service the package provides.
        $this->app->singleton('history', function ($app) {
            return new History;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['history'];
    }
}
