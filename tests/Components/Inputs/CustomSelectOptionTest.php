<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class CustomSelectOptionTest extends ComponentTestCase
{
    /** @test */
    public function can_render_component(): void
    {
        $this->blade('<x-custom-select-option />')
            ->assertSee('custom-select-option')
            ->assertSee('x-data="customSelectOption(', false);
    }

    /** @test */
    public function is_aware_of_a_parent_select_name(): void
    {
        $template = <<<HTML
        <x-custom-select name="foo">
            <x-custom-select-option value="bar" />
        </x-custom-select>
        HTML;

        // Every option gets an id assigned that is a combination of the parent
        // select's name and the option's value.
        $this->blade($template)
            ->assertSee('id="customSelectfooOption-bar"', false);
    }

    /** @test */
    public function can_render_a_checkbox_on_the_option(): void
    {
        $template = <<<HTML
        <x-custom-select name="foo" show-checkbox multiple>
            <x-custom-select-option value="foo" label="Foo" />
        </x-custom-select>
        HTML;

        $this->blade($template)
            ->assertSee('x-bind:checked="optionSelected()"', false)
            ->assertSee('type="checkbox"', false);
    }

    /** @test */
    public function checkbox_is_optional(): void
    {
        $template = <<<HTML
        <x-custom-select name="foo" :show-checkbox="false" multiple>
            <x-custom-select-option value="foo" label="Foo" />
        </x-custom-select>
        HTML;

        $this->blade($template)
            ->assertDontSee('x-bind:checked="optionSelected()"', false)
            ->assertDontSee('type="checkbox"', false);
    }

    /** @test */
    public function label_can_be_slotted(): void
    {
        $template = <<<HTML
        <x-custom-select-option value="foo">My custom label</x-custom-select-option>
        HTML;

        $this->blade($template)
            ->assertSee('<span>My custom label</span>', false);
    }

    /** @test */
    public function can_be_an_opt_group(): void
    {
        $this->blade('<x-custom-select-option value="foo" label="Foo" is-opt-group />')
            ->assertDontSee('x-data')
            ->assertSee('custom-select-option--opt-group')
            ->assertDontSee('x-on:click.stop="toggle"')
            ->assertSee('<span>Foo</span>', false);
    }
}
