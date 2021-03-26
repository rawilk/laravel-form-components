<?php

namespace Rawilk\FormComponents\Tests\Components;

use Spatie\Snapshots\MatchesSnapshots;

class LabelTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_be_rendered(): void
    {
        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-label for="first_name" />')
        );
    }

    /** @test */
    public function a_custom_label_can_be_used(): void
    {
        $template = <<<HTML
        <x-label for="first_name">
            My custom label
        </x-label>
        HTML;

        $this->assertMatchesSnapshot(
            $this->renderComponent($template)
        );
    }

    /** @test */
    public function for_attribute_is_optional(): void
    {
        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-label>Label...</x-label>')
        );
    }

    /** @test */
    public function nothing_is_rendered_if_label_is_empty(): void
    {
        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-label />')
        );
    }
}
