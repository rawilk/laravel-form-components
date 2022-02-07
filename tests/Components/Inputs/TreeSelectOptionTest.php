<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class TreeSelectOptionTest extends ComponentTestCase
{
    /** @test */
    public function can_render_component(): void
    {
        $this->blade('<x-tree-select-option />')
            ->assertSee('tree-select-option')
            ->assertSee('x-data="treeSelectOption(', false);
    }

    /** @test */
    public function is_aware_of_parent_select_name(): void
    {
        $template = <<<HTML
        <x-tree-select name="foo">
            <x-tree-select-option value="bar" />
        </x-tree-select>
        HTML;

        $this->blade($template)
            ->assertSee('id="treeSelectfooOption-bar"', false);
    }

    /** @test */
    public function can_render_a_checkbox_on_the_option(): void
    {
        $template = <<<HTML
        <x-tree-select name="foo" show-checkbox multiple>
            <x-tree-select-option value="foo" label="Foo" />
        </x-tree-select>
        HTML;

        $this->blade($template)
            ->assertSee('x-bind:checked="optionSelected()"', false)
            ->assertSee('type="checkbox"', false);
    }

    /** @test */
    public function checkbox_is_optional(): void
    {
        $template = <<<HTML
        <x-tree-select name="foo" :show-checkbox="false" multiple>
            <x-tree-select-option value="foo" label="Foo" />
        </x-tree-select>
        HTML;

        $this->blade($template)
            ->assertDontSee('x-bind:checked="optionSelected()"', false)
            ->assertDontSee('type="checkbox"', false);
    }

    /** @test */
    public function label_can_be_slotted(): void
    {
        $template = <<<HTML
        <x-tree-select-option value="foo">My custom label</x-tree-select-option>
        HTML;

        $this->blade($template)
            ->assertSee('<span>My custom label</span>', false);
    }

    /** @test */
    public function renders_children_options(): void
    {
        // Note: To render child options, the option must be inside of a tree select component
        // so it can reference the child's value and text keys correctly.
        $children = [
            ['id' => 'child_1', 'name' => 'Child 1', 'children' => []],
            ['id' => 'child_2', 'name' => 'Child 2', 'children' => []],
        ];

        $template = <<<HTML
        <x-tree-select name="foo">
            <x-tree-select-option value="parent_1" label="Parent" :children="\$children" />
        </x-tree-select>
        HTML;

        $this->blade($template, ['children' => $children])
            ->assertSeeInOrder([
                'id="treeSelectfooOption-parent_1"',
                'data-level="0"',
                'tree-select-option__children',
                'id="treeSelectfooOption-child_1"',
                'data-level="1"',
                'id="treeSelectfooOption-child_2"',
            ], false);
    }
}
