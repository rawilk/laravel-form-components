<?php

namespace Rawilk\LaravelFormComponents;

use Illuminate\Support\ServiceProvider;
use Rawilk\LaravelFormComponents\Commands\LaravelFormComponentsCommand;

class LaravelFormComponentsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-form-components.php' => config_path('laravel-form-components.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/laravel-form-components'),
            ], 'views');

            if (! class_exists('CreatePackageTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_laravel_form_components_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_laravel_form_components_table.php'),
                ], 'migrations');
            }

            $this->commands([
                LaravelFormComponentsCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-form-components');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-form-components.php', 'laravel-form-components');
    }
}
