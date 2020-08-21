<?php

namespace Rawilk\LaravelFormComponents\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Rawilk\LaravelFormComponents\LaravelFormComponentsServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/database/factories');
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelFormComponentsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        // include_once __DIR__ . '/../database/migrations/create_laravel_form_components_table.php.stub';
        // (new \CreatePackageTable())->up();
    }
}
