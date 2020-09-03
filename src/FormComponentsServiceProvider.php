<?php

declare(strict_types=1);

namespace Rawilk\FormComponents;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class FormComponentsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->bootResources();
        $this->bootBladeComponents();

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/form-components.php', 'form-components');
    }

    private function bootBladeComponents(): void
    {
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $prefix = config('form-components.prefix', '');

            foreach (config('form-components.components', []) as $alias => $component) {
                $blade->component($component['class'], $alias, $prefix);
            }
        });
    }

    private function bootForConsole(): void
    {
        $this->publishes([
            __DIR__ . '/../config/form-components.php' => $this->app->configPath('form-components.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/views' => $this->app->resourcePath('views/vendor/form-components'),
        ], 'views');
    }

    private function bootResources(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'form-components');
    }
}
