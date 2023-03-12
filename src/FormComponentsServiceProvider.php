<?php

declare(strict_types=1);

namespace Rawilk\FormComponents;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\ComponentAttributeBag;
use Rawilk\FormComponents\Controllers\FormComponentsJavaScriptAssets;
use Rawilk\FormComponents\Support\Timezone;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FormComponentsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-form-components')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasViews();
    }

    public function packageBooted(): void
    {
        $this->bootBladeComponents();
        $this->bootDirectives();
        $this->bootMacros();
        $this->bootRoutes();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton('form-components', FormComponents::class);
        $this->registerTimezone();
    }

    private function bootBladeComponents(): void
    {
        // Register all components under a single namespace.
        Blade::componentNamespace('Rawilk\\FormComponents\\Components', 'form-components');

        // Register aliases for certain components.
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $prefix = config('form-components.prefix', '');

            foreach (config('form-components.components', []) as $alias => $component) {
                $blade->component($component, $alias, $prefix);
            }
        });
    }

    private function bootDirectives(): void
    {
        Blade::directive('fcJavaScript', function (string $expression) {
            return "<?php echo \\Rawilk\\FormComponents\\Facades\\FormComponents::javaScript({$expression}); ?>";
        });
    }

    private function bootMacros(): void
    {
        if (! ComponentAttributeBag::hasMacro('hasStartsWith')) {
            ComponentAttributeBag::macro('hasStartsWith', function ($key) {
                return (bool) $this->whereStartsWith($key)->first();
            });
        }
    }

    private function bootRoutes(): void
    {
        Route::get('/form-components/form-components.js', [FormComponentsJavaScriptAssets::class, 'source']);
        Route::get('/form-components/form-components.js.map', [FormComponentsJavaScriptAssets::class, 'maps']);
    }

    private function registerTimezone(): void
    {
        if (config('form-components.enable_timezone')) {
            $this->app->singleton('fc-timezone', fn () => new Timezone);
        }
    }
}
