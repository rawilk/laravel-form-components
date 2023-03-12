<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Livewire\Livewire;
use Orchestra\Testbench\TestCase as Orchestra;
use Rawilk\FormComponents\FormComponentsServiceProvider2;
use Rawilk\FormComponents\Tests\Components\Support\BlankLivewireComponent;

abstract class TestCase extends Orchestra
{
    use InteractsWithViews;

    protected $enablesPackageDiscoveries = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        Livewire::component('blank-livewire-component', BlankLivewireComponent::class);
    }

    protected function getPackageProviders($app): array
    {
        return [
            FormComponentsServiceProvider2::class,
        ];
    }
}
