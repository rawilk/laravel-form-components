<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class TreeSelectTest extends ComponentTestCase
{
    /** @test */
    public function can_render_component(): void
    {
        $this->blade('<x-tree-select />')
            ->assertSee('x-data="treeSelect({', false)
            ->assertSee('x-ref="menu"', false)
            ->assertSee('tree-select__button');
    }

    /** @test */
    public function renders_an_array_of_options(): void
    {
        $options = [
            ['id' => 'foo', 'name' => 'Foo'],
            ['id' => 'bar', 'name' => 'Bar'],
        ];

        $template = <<<'HTML'
        <x-tree-select name="foo" :options="$options" />
        HTML;

        // By default, each option renders the label of an option in a <span> tag.
        $this->blade($template, ['options' => $options])
            ->assertSee('tree-select-option')
            ->assertSeeInOrder([
                '<span>Foo</span>',
                '<span>Bar</span>',
            ], false);
    }

    /** @test */
    public function hidden_inputs_are_rendered_without_a_wire_model_or_x_model_present(): void
    {
        $this->blade('<x-tree-select name="foo" />')
            ->assertSee('<input type="hidden" name="foo" x-bind:value="value">', false);

        $this->blade('<x-tree-select name="foo" multiple />')
            ->assertSeeInOrder([
                '<template x-for="singleValue in value">',
                '<input type="hidden" name="foo[]" x-bind:value="singleValue"',
                '</template>',
            ], false);
    }

    /** @test */
    public function hidden_inputs_are_not_rendered_with_model_binding_present(): void
    {
        $template = <<<'HTML'
        <x-tree-select name="foo" wire:model.defer="foo" />
        HTML;

        $this->blade('<livewire:blank-livewire-component :template="$template" />', ['template' => $template])
            ->assertSee('_wire: window.livewire.find(')
            ->assertSee('value: window.Livewire.find(')
            ->assertSee('_wireModelName: \'foo\'', false)
            ->assertDontSee('<input type="hidden" name="foo" x-bind:value="value">', false);

        $this->blade('<x-tree-select name="foo" x-model.debounce="foo" />')
            ->assertSee('value: foo')
            ->assertDontSee('<input type="hidden" name="foo" x-bind:value="value">', false);
    }
}
