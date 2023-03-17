<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Illuminate\Support\HtmlString;
use Rawilk\FormComponents\Tests\Components\ComponentTestCase;
use Spatie\Snapshots\MatchesSnapshots;

class InputTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_be_rendered(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-input name="search" />')
        );
    }

    /** @test */
    public function specific_attributes_can_be_overwritten(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-input name="confirm_password" id="confirmPassword" type="password" class="p-4" />')
        );
    }

    /** @test */
    public function inputs_can_have_old_values(): void
    {
        $this->flashOld(['search' => 'Eloquent']);
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-input name="search" />')
        );
    }

    /** @test */
    public function does_not_add_value_attribute_if_wire_model_present(): void
    {
        $this->flashOld(['search' => 'Eloquent']);
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-input name="search" wire:model="search" />')
        );
    }

    /** @test */
    public function can_have_leading_addon(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-input name="search" leading-addon="foo" />')
        );
    }

    /** @test */
    public function leading_addon_can_be_slotted(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-input name="search">
            <x-slot name="leadingAddon">foo</x-slot>
        </x-input>
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function can_have_inline_addon(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-input name="search" inline-addon="foo" />')
        );
    }

    /** @test */
    public function can_have_custom_inline_addon_padding(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-input name="search" inline-addon="foo" inline-addon-padding="pl-20" />')
        );
    }

    /** @test */
    public function inline_addon_can_be_slotted(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-input name="search">
            <x-slot name="inlineAddon">foo</x-slot>
        </x-input>
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function can_have_leading_icon(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-input name="search">
            <x-slot name="leadingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function only_renders_one_type_of_leading_addon(): void
    {
        $this->withViewErrors([]);

        // leading-addon should be the only one rendered.
        $template = <<<'HTML'
        <x-input name="search" leading-addon="foo" inline-addon="bar">
            <x-slot name="leadingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function can_have_trailing_addon(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-input name="search" trailing-addon="foo" />')
        );
    }

    /** @test */
    public function can_have_custom_trailing_addon_padding(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-input name="search" trailing-addon="foo" trailing-addon-padding="pr-20" />')
        );
    }

    /** @test */
    public function trailing_addon_can_be_slotted(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-input name="search" trailing-addon-padding="pr-20">
            <x-slot name="trailingAddon">
                foo slotted
            </x-slot>
        </x-input>
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function can_have_trailing_icon(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-input name="search">
            <x-slot name="trailingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function will_only_render_one_type_of_trailing_addon(): void
    {
        $this->withViewErrors([]);

        // should only render the trailing-addon.
        $template = <<<'HTML'
        <x-input name="search" trailing-addon="foo">
            <x-slot name="trailingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function can_have_both_leading_and_trailing_addons(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-input name="search" leading-addon="foo">
            <x-slot name="trailingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function it_adds_aria_attributes_when_there_is_an_error(): void
    {
        $this->withViewErrors(['search' => 'required']);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-input name="search" id="inputSearch" />')
        );
    }

    /** @test */
    public function it_combines_aria_describedby_on_error_if_the_attribute_is_present(): void
    {
        $this->withViewErrors(['search' => 'required']);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-input name="search" aria-describedby="search-help" />')
        );
    }

    /** @test */
    public function can_have_a_max_width_set_on_the_container(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-input max-width="sm" name="name" />
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-input name="name" container-class="foo" />')
        );
    }

    /** @test */
    public function name_can_be_omitted(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-input />')
        );
    }

    /** @test */
    public function can_have_extra_attributes(): void
    {
        $this->withViewErrors([]);

        $attributes = new HtmlString(implode(PHP_EOL, [
            'x-data',
            'x-ref="foo"',
            'x-on:keydown="$wire.submit()"',
        ]));

        $template = <<<'HTML'
        <x-input name="foo" :extra-attributes="$attributes" />
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template, compact('attributes')));
    }
}
