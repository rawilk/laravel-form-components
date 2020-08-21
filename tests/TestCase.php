<?php

namespace Rawilk\Skeleton\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Rawilk\Skeleton\SkeletonServiceProvider;

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
            SkeletonServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        // include_once __DIR__ . '/../database/migrations/create_skeleton_table.php.stub';
        // (new \CreatePackageTable())->up();
    }
}
