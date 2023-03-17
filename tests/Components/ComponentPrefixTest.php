<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components;

class ComponentPrefixTest extends ComponentTestCase
{
    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('form-components.prefix', 'tw');
    }

    /** @test */
    public function a_custom_prefix_can_be_used(): void
    {
        $expected = <<<'HTML'
        <form method="POST" action="http://example.com" spellcheck="false">
            <input type="hidden" name="_token" value="">
        </form>
        HTML;

        $this->assertComponentRenders($expected, '<x-tw-form action="http://example.com" />');
    }
}
