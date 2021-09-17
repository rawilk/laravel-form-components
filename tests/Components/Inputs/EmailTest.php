<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class EmailTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->blade('<x-email name="email" />')
            ->assertSee('type="email"', false)
            ->assertSee('<input', false)
            ->assertSee('form-input')
            ->assertSee('name="email"', false);
    }

    /** @test */
    public function email_type_will_not_be_overridden(): void
    {
        $this->blade('<x-email name="foo" id="bar" class="custom-class" type="url" />')
            ->assertDontSee('type="url"', false)
            ->assertSee('type="email"', false)
            ->assertSee('custom-class')
            ->assertSee('id="bar"', false);
    }
}
