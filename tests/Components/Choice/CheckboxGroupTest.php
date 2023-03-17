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
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-checkbox-group>Checkboxes...</x-checkbox-group>')
        );
    }

    /** @test */
    public function can_be_not_stacked(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-checkbox-group :stacked="$stacked">Checkboxes...</x-checkbox-group>', ['stacked' => false])
        );
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

        $this->assertMatchesSnapshot((string) $this->blade($template));
    }
}
