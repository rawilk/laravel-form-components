<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class CustomSelectTest extends ComponentTestCase
{
    /** @test */
    public function can_render_component(): void
    {
        $this->blade('<x-custom-select />')
            ->assertSee('x-data="customSelect({', false)
            ->assertSee('x-ref="container"', false)
            ->assertSee('custom-select__menu-container');
    }
}
