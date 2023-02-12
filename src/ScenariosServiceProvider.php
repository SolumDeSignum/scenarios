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
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/../config/scenarios.php' => config_path(
                        'scenarios.php'
                    ),
                ],
                'config'
            );
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
}
