<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Support;

trait SetsComponentPrefix
{
    protected function getEnvironmentSetup($app): void
    {
        parent::getEnvironmentSetup($app);

        $app['config']->set('form-components.prefix', 'tw');
    }
}
