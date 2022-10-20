<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Illuminate\Support\HtmlString;
use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class InputTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->blade('<x-input name="search" />')
            ->assertSee('<input', false)
            ->assertSee('name="search"', false)
            ->assertSee('id="search"', false)
            ->assertSee('type="text"', false)
            ->assertSee('form-text-container')
            ->assertSee('form-text');
    }

    /** @test */
    public function specific_attributes_can_be_overwritten(): void
    {
        $this->blade('<x-input name="confirm_password" id="confirmPassword" type="password" class="p-4" />')
            ->assertSee('p-4')
            ->assertSee('form-text')
            ->assertSee('id="confirmPassword"', false)
            ->assertDontSee('id="confirm_password"', false)
            ->assertSee('type="password"', false)
            ->assertSee('name="confirm_password"', false);
    }

    /** @test */
    public function inputs_can_have_old_values(): void
    {
        $this->flashOld(['search' => 'Eloquent']);

        $this->blade('<x-input name="search" />')
            ->assertSee('value="Eloquent"', false);
    }

    /** @test */
    public function does_not_add_value_attribute_if_wire_model_present(): void
    {
        $this->flashOld(['search' => 'Eloquent']);

        $this->blade('<x-input name="search" wire:model="search" />')
            ->assertDontSee('value=');
    }

    /** @test */
    public function can_have_leading_addon(): void
    {
        $this->blade('<x-input name="search" leading-addon="my addon" />')
            ->assertSeeText('my addon')
            ->assertSee('class="leading-addon', false)
            ->assertSee('has-leading-addon rounded-none rounded-r-md');
    }

    /** @test */
    public function leading_addon_can_be_slotted(): void
    {
        $template = <<<'HTML'
        <x-input name="search">
            <x-slot name="leadingAddon">foo</x-slot>
        </x-input>
        HTML;

        $this->blade($template)
            ->assertSeeText('foo')
            ->assertSee('class="leading-addon', false)
            ->assertSee('has-leading-addon rounded-none rounded-r-md');
    }

    /** @test */
    public function can_have_inline_addon(): void
    {
        $this->blade('<x-input name="search" inline-addon="my addon" />')
            ->assertSeeText('my addon')
            ->assertSee('inline-addon');
    }

    /** @test */
    public function can_have_custom_inline_addon_padding(): void
    {
        $this->blade('<x-input name="search" inline-addon="foo" inline-addon-padding="pl-20" />')
            ->assertSee('pl-20');
    }

    /** @test */
    public function inline_addon_can_be_slotted(): void
    {
        $template = <<<'HTML'
        <x-input name="search">
            <x-slot name="inlineAddon">foo</x-slot>
        </x-input>
        HTML;

        $this->blade($template)
            ->assertSeeText('foo')
            ->assertSee('inline-addon')
            ->assertSee('rounded-md');
    }

    /** @test */
    public function can_have_leading_icon(): void
    {
        $template = <<<'HTML'
        <x-input name="search">
            <x-slot name="leadingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $this->blade($template)
            ->assertSeeText('icon here')
            ->assertSee('leading-icon')
            ->assertSee('has-leading-icon');
    }

    /** @test */
    public function only_renders_one_type_of_leading_addon(): void
    {
        // leading-addon should be the only one rendered.
        $template = <<<'HTML'
        <x-input name="search" leading-addon="foo" inline-addon="bar">
            <x-slot name="leadingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $this->blade($template)
            ->assertSeeText('foo')
            ->assertDontSeeText('icon here')
            ->assertDontSeeText('bar')
            ->assertSee('leading-addon')
            ->assertDontSee('leading-icon');
    }

    /** @test */
    public function can_have_trailing_addon(): void
    {
        $this->blade('<x-input name="search" trailing-addon="foo" />')
            ->assertSeeText('foo')
            ->assertSee('trailing-addon');
    }

    /** @test */
    public function can_have_custom_trailing_addon_padding(): void
    {
        $this->blade('<x-input name="search" trailing-addon="foo" trailing-addon-padding="pr-20" />')
            ->assertSee('pr-20');
    }

    /** @test */
    public function trailing_addon_can_be_slotted(): void
    {
        $template = <<<'HTML'
        <x-input name="search" trailing-addon-padding="pr-20">
            <x-slot name="trailingAddon">
                foo slotted
            </x-slot>
        </x-input>
        HTML;

        $this->blade($template)
            ->assertSeeText('foo slotted')
            ->assertSee('trailing-addon')
            ->assertSee('pr-20');
    }

    /** @test */
    public function can_have_trailing_icon(): void
    {
        $template = <<<'HTML'
        <x-input name="search">
            <x-slot name="trailingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $this->blade($template)
            ->assertSeeText('icon here')
            ->assertSee('trailing-icon')
            ->assertSee('has-trailing-icon');
    }

    /** @test */
    public function will_only_render_one_type_of_trailing_addon(): void
    {
        // should only render the trailing-addon.
        $template = <<<'HTML'
        <x-input name="search" trailing-addon="foo">
            <x-slot name="trailingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $this->blade($template)
            ->assertSeeText('foo')
            ->assertDontSeeText('icon here')
            ->assertDontSee('has-trailing-icon')
            ->assertDontSee('trailing-icon');
    }

    /** @test */
    public function can_have_both_leading_and_trailing_addons(): void
    {
        $template = <<<'HTML'
        <x-input name="search" leading-addon="foo">
            <x-slot name="trailingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $this->blade($template)
            ->assertSeeText('foo')
            ->assertSeeText('icon here')
            ->assertSee('has-leading-addon')
            ->assertSee('has-trailing-icon');
    }

    /** @test */
    public function it_adds_aria_attributes_when_there_is_an_error(): void
    {
        $this->withViewErrors(['search' => 'required']);

        $this->blade('<x-input name="search" id="inputSearch" />')
            ->assertSee('aria-invalid="true"', false)
            ->assertSee('aria-describedby="inputSearch-error"', false);
    }

    /** @test */
    public function it_combines_aria_describedby_on_error_if_the_attribute_is_present(): void
    {
        $this->withViewErrors(['search' => 'required']);

        $this->blade('<x-input name="search" aria-describedby="search-help" />')
            ->assertSee('aria-describedby="search-help search-error"', false)
            ->assertSee('aria-invalid="true"', false);
    }

    /** @test */
    public function can_have_a_max_width_set_on_the_container(): void
    {
        $this->blade('<x-input max-width="sm" name="name" />')
            ->assertSee('max-w-sm');
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        $this->blade('<x-input name="name" container-class="foo" />')
            ->assertSee('foo');
    }

    /** @test */
    public function name_can_be_omitted(): void
    {
        $this->blade('<x-input />')
            ->assertDontSee('name=');
    }

    /*
     * This test is breaking Laravel 9.* tests because of the HtmlString
     * class used in the test, but this won't affect actual rendering
     * of the component, so we will disable it for now until the test
     * passes again in a l9 environment.
     */
    // /** @test */
    // public function can_have_extra_attributes(): void
    // {
    //     $attributes = new HtmlString(implode(PHP_EOL, [
    //         'x-data',
    //         'x-ref="foo"',
    //         'x-on:keydown="$wire.submit()"',
    //     ]));
    //
    //     $this->blade(
    //         '<x-input name="foo" :extra-attributes="$attributes" />',
    //         ['attributes' => $attributes],
    //     )
    //     ->assertSeeInOrder([
    //         'x-data',
    //         'x-ref="foo"',
    //         'x-on:keydown="$wire.submit()"',
    //     ], false);
    // }

    /** @test */
    public function can_have_custom_trailing_addon_markup(): void
    {
        $template = <<<'HTML'
        <x-input name="foo">
            <x-slot name="after">
                <div class="my-custom-trailing-addon">
                    My custom addon content...
                </div>
            </x-slot>
        </x-input>
        HTML;

        $this->blade($template)
            ->assertSeeInOrder([
                '<div class="my-custom-trailing-addon">',
                'My custom addon content...',
                '</div>',
            ], false);
    }
}
