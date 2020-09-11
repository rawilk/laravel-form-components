<?php

namespace Rawilk\FormComponents\Tests\Unit;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

class HelpersTest extends ComponentTestCase
{
    /** @test */
    public function can_get_a_components_prefixed_name(): void
    {
        self::assertSame('form-group', formComponentName('form-group'));

        config(['form-components.prefix' => 'tw']);

        self::assertSame('tw-form-group', formComponentName('form-group'));
    }
}
