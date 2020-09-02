<?php

namespace Rawilk\FormComponents;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Rawilk\FormComponents\Support\FormDataBinder;

class FormComponentsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'form-components');

        $this->registerDirectives();
        $this->registerComponents();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/form-components.php', 'form-components');

        $this->app->singleton(FormDataBinder::class, fn () => new FormDataBinder);
    }

    protected function registerComponents(): void
    {
        $prefix = config('form-components.prefix');

        Collection::make(config('form-components.components'))
            ->each(fn ($component, $alias) => Blade::component($alias, $component['class'], $prefix));
    }

    protected function registerDirectives(): void
    {
        Blade::directive(
            'bind',
            fn ($bind) => '<?php app(\Rawilk\FormComponents\Support\FormDataBinder::class)->bind(' . $bind . '); ?>'
        );

        Blade::directive(
            'endbind',
            fn () => '<?php app(\Rawilk\FormComponents\Support\FormDataBinder::class)->pop(); ?>'
        );

        Blade::directive(
            'wire',
            fn () => '<?php app(\Rawilk\FormComponents\Support\FormDataBinder::class)->wire(); ?>'
        );

        Blade::directive(
            'endwire',
            fn () => '<?php app(\Rawilk\FormComponents\Support\FormDataBinder::class)->endWire(); ?>'
        );
    }

    protected function bootForConsole(): void
    {
        $this->publishes([
            __DIR__ . '/../config/form-components.php' => config_path('form-components.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/form-components'),
        ], 'views');
    }
}
