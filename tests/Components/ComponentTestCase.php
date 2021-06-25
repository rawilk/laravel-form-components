<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Orchestra\Testbench\TestCase;
use Rawilk\FormComponents\FormComponentsServiceProvider;
use ReflectionProperty;

abstract class ComponentTestCase extends TestCase
{
    use InteractsWithViews;

    protected function setUp(): void
    {
        parent::setUp();

        $this->initSession();

        // TODO: get this line to work in github tests workflow for php8 -- prefer lowest test
        // $this->artisan('view:clear');
    }

    protected function initSession(): void
    {
        // This is to avoid "Session store not set on request" errors for some components.
        $session = new ReflectionProperty(app('request'), 'session');
        $session->setAccessible(true);
        $session->setValue(app('request'), app('session')->driver('array'));
    }

    protected function flashOld(array $input): void
    {
        session()->flashInput($input);

        request()->setLaravelSession(session());
    }

    protected function getPackageProviders($app): array
    {
        return [
            BladeIconsServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            FormComponentsServiceProvider::class,
        ];
    }
}
