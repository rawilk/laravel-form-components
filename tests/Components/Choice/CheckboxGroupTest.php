<?php

namespace Rawilk\FormComponents\Tests\Components\Choice;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

class CheckboxGroupTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $template = <<<HTML
        <x-checkbox-group>
            Checkboxes...
        </x-checkbox-group>
        HTML;

        $expected = <<<HTML
        <div class="space-y-4">
            Checkboxes...
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function can_be_not_stacked(): void
    {
        $template = <<<HTML
        <x-checkbox-group :stacked="false">
            Checkboxes...
        </x-checkbox-group>
        HTML;

        $expected = <<<HTML
        <div class="form-checkbox-group">
            Checkboxes...
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }
}
