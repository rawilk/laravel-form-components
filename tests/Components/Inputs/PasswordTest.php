<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class PasswordTest extends ComponentTestCase
{
    /** @test */
    public function can_render_component(): void
    {
        $this->blade('<x-password name="password" />')
            ->assertSee('<input', false)
            ->assertSee('x-bind:type="show ? \'text\' : \'password\'"', false)
            ->assertSee('name="password"', false)
            ->assertSee('password-toggleable')
            ->assertSee('password-input-container')
            ->assertSee('password-toggle')
            ->assertSee('x-data="{ show: false }"', false);
    }

    /** @test */
    public function show_toggle_password_can_be_disabled(): void
    {
        $this->blade('<x-password name="password" :show-toggle="false" />')
            ->assertSee('type="password"', false)
            ->assertDontSee('password-toggle')
            ->assertDontSee('password-toggleable')
            ->assertDontSee('x-data="{ show: false }"', false);
    }

    /** @test */
    public function can_have_leading_addon(): void
    {
        $this->blade('<x-password name="password" leading-addon="foo" />')
            ->assertSeeText('foo')
            ->assertSee('has-leading-addon');
    }

    /** @test */
    public function it_ignores_trailing_addons(): void
    {
        $this->blade('<x-password name="password" trailing-addon="foo" />')
            ->assertDontSeeText('foo')
            ->assertSee('password-toggle');
    }

    /** @test */
    public function slotted_trailing_addons_are_ignored(): void
    {
        // Even if we try to specify a trailing addon, the component should render its toggle trailing addon instead.
        $template = <<<'HTML'
        <x-password name="password" leading-addon="leading addon">
            <x-slot name="trailingAddon">trailing addon</x-slot>
        </x-password>
        HTML;

        $this->blade($template)
            ->assertSeeText('leading addon')
            ->assertDontSeeText('trailing addon')
            ->assertSee('leading-addon')
            ->assertDontSee('trailing-addon');
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        $this->blade('<x-password name="name" container-class="foo" />')
            ->assertSee('foo');
    }

    /** @test */
    public function name_can_be_omitted(): void
    {
        $this->blade('<x-password />')
            ->assertDontSee('name=')
            ->assertDontSee('id=');
    }
}
