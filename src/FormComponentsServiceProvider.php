<?php

declare(strict_types=1);

namespace Rawilk\FormComponents;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;
use Rawilk\FormComponents\Console\PublishCommand;
use Rawilk\FormComponents\Controllers\FormComponentsJavaScriptAssets;
use Rawilk\FormComponents\Facades\FormComponents as FormComponentsFacade;
use Rawilk\FormComponents\Support\Timezone;

class FormComponentsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->bootResources();
        $this->bootRoutes();
        $this->bootBladeComponents();
        $this->bootDirectives();

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();

            $this->commands([
                PublishCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        $this->registerFacade();
        $this->mergeConfigFrom(__DIR__ . '/../config/form-components.php', 'form-components');
        $this->registerTimezone();
    }

    private function registerFacade(): void
    {
        $this->app->singleton('form-components', FormComponents::class);
    }

    private function bootBladeComponents(): void
    {
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $prefix = config('form-components.prefix', '');
            $assets = config('form-components.assets', []);

            foreach (config('form-components.components', []) as $alias => $component) {
                $blade->component($component['class'], $alias, $prefix);

                $this->registerAssets($component['class'], $assets);
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

    private function bootDirectives(): void
    {
        Blade::directive('fcStyles', function (string $expression) {
            return "<?php echo \\Rawilk\\FormComponents\\Facades\\FormComponents::outputStyles({$expression}); ?>";
        });

        Blade::directive('fcScripts', function (string $expression) {
            return "<?php echo \\Rawilk\\FormComponents\\Facades\\FormComponents::outputScripts({$expression}); ?>";
        });

        Blade::directive('fcJavaScript', function (string $expression) {
            return "<?php echo \\Rawilk\\FormComponents\\Facades\\FormComponents::javaScript({$expression}); ?>";
        });
    }

    private function bootRoutes(): void
    {
        Route::get('/form-components/form-components.js', [FormComponentsJavaScriptAssets::class, 'source']);
        Route::get('/form-components/form-components.js.map', [FormComponentsJavaScriptAssets::class, 'maps']);
    }

    private function registerAssets($component, array $assets): void
    {
        foreach ($component::assets() as $asset) {
            $files = (array) ($assets[$asset] ?? []);

            collect($files)->filter(function (string $file) {
                return Str::endsWith($file, '.css');
            })->each(fn (string $style) => FormComponentsFacade::addStyle($style));

            collect($files)->filter(function (string $file) {
                return Str::endsWith($file, '.js');
            })->each(fn (string $script) => FormComponentsFacade::addScript($script));
        }
    }

    private function registerTimezone(): void
    {
        if (config('form-components.enable_timezone')) {
            $this->app->singleton('fc-timezone', fn () => new Timezone);
        }
    }
}
