<?php

namespace Rawilk\FormComponents\Tests\Concerns;

use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\View;
use Rawilk\FormComponents\Tests\TestView;

trait InteractsWithViews
{
    /**
     * Create a new TestView from the given view.
     *
     * @param string $view
     * @param array $data
     * @return \Rawilk\FormComponents\Tests\TestView
     */
    public function view(string $view, array $data = []): TestView
    {
        return new TestView(view($view, $data));
    }

    /**
     * Render the contents of the given Blade template string.
     *
     * @param string $template
     * @param array $data
     * @return \Rawilk\FormComponents\Tests\TestView
     */
    protected function blade(string $template, array $data = []): TestView
    {
        $tempDirectory = sys_get_temp_dir();

        if (! in_array($tempDirectory, ViewFacade::getFinder()->getPaths(), true)) {
            ViewFacade::addLocation(sys_get_temp_dir());
        }

        $tempFile = tempnam($tempDirectory, 'laravel-blade') . '.blade.php';

        file_put_contents($tempFile, $template);

        return new TestView(view(Str::before(basename($tempFile), '.blade.php'), $data));
    }

    /**
     * Render the given view component.
     *
     * @param string $componentClass
     * @param array $data
     * @return \Rawilk\FormComponents\Tests\TestView
     */
    protected function component(string $componentClass, array $data = []): TestView
    {
        $component = $this->app->make($componentClass, $data);

        $view = $component->resolveView();

        return $view instanceof View
            ? new TestView($view->with($component->data()))
            : new TestView(view($view, $component->data()));
    }

    /**
     * Populate the shared view error bag with the given errors.
     *
     * @param array $errors
     * @param string $bag
     */
    protected function withViewErrors(array $errors, string $bag = 'default'): void
    {
        ViewFacade::share('errors', (new ViewErrorBag)->put($bag, new MessageBag($errors)));
    }
}
