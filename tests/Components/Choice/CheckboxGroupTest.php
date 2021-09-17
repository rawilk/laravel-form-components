<?php

namespace Rawilk\FormComponents\Tests\Components\Choice;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class CheckboxGroupTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->blade('<x-checkbox-group>Checkboxes...</x-checkbox-group>')
            ->assertSeeText('Checkboxes...')
            ->assertSee('space-y-4');
    }

    /** @test */
    public function can_be_not_stacked(): void
    {
        $this->blade('<x-checkbox-group :stacked="false">Checkboxes...</x-checkbox-group>')
            ->assertSee('grid')
            ->assertDontSee('space-y-4');
    }

    /** @test */
    public function can_have_a_custom_amount_of_grid_columns(): void
    {
        $template = <<<HTML
        <x-checkbox-group :stacked="false" grid-cols="6">
            <div>checkbox 1</div>
            <div>checkbox 2</div>
        </x-checkbox-group>
        HTML;

        $this->blade($template)
            ->assertSee('--fc-checkbox-grid-cols: 6;', false);
    }
}
