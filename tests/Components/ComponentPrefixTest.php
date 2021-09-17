<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components;

final class ComponentPrefixTest extends ComponentTestCase
{
    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('form-components.prefix', 'tw');
    }

    /** @test */
    public function a_custom_prefix_can_be_used(): void
    {
        $this->blade('<x-tw-form action="http://example.com" />')
            ->assertSee('<form', false)
            ->assertSee('action=');
    }
}
