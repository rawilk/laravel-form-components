<?php

namespace Rawilk\FormComponents\Tests\Components\Choice;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class RadioTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->blade('<x-radio name="remember_me" />')
            ->assertSee('<input', false)
            ->assertSee('name="remember_me"', false)
            ->assertSee('type="radio"', false)
            ->assertSee('form-radio');
    }
}
