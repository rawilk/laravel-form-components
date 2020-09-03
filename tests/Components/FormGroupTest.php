<?php

namespace Rawilk\FormComponents\Tests\Components;

class FormGroupTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-form-group label="First name" name="first_name">
            Name input
        </x-form-group>
        HTML;

        $expected = <<<HTML
        <div class="form-group">
            <label for="first_name" class="form-label">
                First name
            </label>

            <div class="mt-1">
                Name input
            </div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }
}
