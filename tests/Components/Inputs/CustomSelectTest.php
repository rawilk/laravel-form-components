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
            ->assertSee('x-ref="menu"', false)
            ->assertSee('custom-select__button');
    }

    /** @test */
    public function renders_an_array_of_options(): void
    {
        $options = [
            ['id' => 'foo', 'name' => 'Foo'],
            ['id' => 'bar', 'name' => 'Bar'],
        ];

        $template = <<<HTML
        <x-custom-select name="foo" :options="\$options" />
        HTML;

        // By default, each option renders the label of an option in a <span> tag.
        $this->blade($template, ['options' => $options])
            ->assertSee('custom-select-option')
            ->assertSeeInOrder([
                '<span>Foo</span>',
                '<span>Bar</span>',
            ], false);
    }

    /** @test */
    public function can_render_slotted_options(): void
    {
        $template = <<<HTML
        <x-custom-select name="foo">
            <x-custom-select-option value="foo" label="Foo" />
            <x-custom-select-option value="bar" label="Bar" />
        </x-custom-select>
        HTML;

        $this->blade($template)
            ->assertSeeInOrder([
                'id="customSelectfooOption-foo"',
                '<span>Foo</span>',
                'id="customSelectfooOption-bar"',
                '<span>Bar</span>',
            ], false);
    }

    /** @test */
    public function can_render_a_flat_array_of_options(): void
    {
        $options = ['foo', 'bar'];

        $this->blade(
            '<x-custom-select name="foo" :options="$options" />',
            ['options' => $options]
        )->assertSeeInOrder([
            'id="customSelectfooOption-foo"',
            '<span>foo</span>',
            'id="customSelectfooOption-bar"',
            '<span>bar</span>',
        ], false);
    }

    /** @test */
    public function can_use_custom_value_and_label_keys(): void
    {
        $options = [
            ['value' => 'foo', 'text' => 'Foo'],
            ['value' => 'bar', 'text' => 'Bar'],
        ];

        $this->blade(
            '<x-custom-select name="foo" :options="$options" value-field="value" label-field="text" />',
            ['options' => $options]
        )->assertSee('custom-select-option')
        ->assertSeeInOrder([
            'id="customSelectfooOption-foo"',
            '<span>Foo</span>',
            'id="customSelectfooOption-bar"',
            '<span>Bar</span>',
        ], false);
    }

    /** @test */
    public function hidden_inputs_are_rendered_without_a_wire_model_or_x_model_present(): void
    {
        $this->blade('<x-custom-select name="foo" />')
            ->assertSee('<input type="hidden" name="foo" x-bind:value="value">', false);

        $this->blade('<x-custom-select name="foo" multiple />')
            ->assertSeeInOrder([
                '<template x-for="singleValue in value">',
                '<input type="hidden" name="foo[]" x-bind:value="singleValue">',
                '</template>',
            ], false);
    }

    /** @test */
    public function hidden_inputs_are_not_rendered_with_model_binding_present(): void
    {
        $template = <<<HTML
        <x-custom-select name="foo" wire:model="foo" />
        HTML;

        $this->blade('<livewire:blank-livewire-component :template="$template" />', ['template' => $template])
            ->assertSee('_wire: window.livewire.find(')
            ->assertSee('value: window.Livewire.find(')
            ->assertDontSee('_wireModelName: \'foo\'')
            ->assertDontSee('<input type="hidden" name="foo" x-bind:value="value">', false);

        $this->blade('<x-custom-select name="foo" x-model="foo" />')
            ->assertSee('value: foo')
            ->assertDontSee('<input type="hidden" name="foo" x-bind:value="value">', false);
    }
}
