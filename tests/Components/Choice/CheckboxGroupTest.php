<?php

namespace Rawilk\FormComponents\Tests\Components\Choice;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;
use Spatie\Snapshots\MatchesSnapshots;

class CheckboxGroupTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_be_rendered(): void
    {
        $template = <<<'HTML'
        <x-checkbox-group>
            Checkboxes...
        </x-checkbox-group>
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function can_be_not_stacked(): void
    {
        $template = <<<'HTML'
        <x-checkbox-group :stacked="false">
            Checkboxes...
        </x-checkbox-group>
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function can_have_a_custom_amount_of_grid_columns(): void
    {
        $template = <<<'HTML'
        <x-checkbox-group :stacked="false" grid-cols="6">
            <div>checkbox 1</div>
            <div>checkbox 2</div>
        </x-checkbox-group>
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }
}
