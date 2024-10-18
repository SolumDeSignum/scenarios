<?php

declare(strict_types=1);

namespace SolumDeSignum\Scenarios;

use Illuminate\Support\ServiceProvider;

class ScenariosServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/scenarios.php',
            'scenarios'
        );
    }

    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/scenarios.php' => config_path('scenarios.php')
        ],
            'scenarios.config'
        );
    }
}
