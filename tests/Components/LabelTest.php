<?php

namespace Rawilk\FormComponents\Tests\Components;

class LabelTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $expected = <<<'HTML'
        <label for="first_name" class="form-label">
            First name
        </label>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-label for="first_name" />'
        );
    }

    /** @test */
    public function a_custom_label_can_be_used(): void
    {
        $template = <<<'HTML'
        <x-label for="first_name">
            My custom label
        </x-label>
        HTML;

        $expected = <<<'HTML'
        <label for="first_name" class="form-label">
            My custom label
        </label>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function for_attribute_is_optional(): void
    {
        $expected = <<<'HTML'
        <label class="form-label">
            Label...
        </label>
        HTML;

        $this->assertComponentRenders($expected, '<x-label>Label...</x-label>');
    }

    /** @test */
    public function nothing_is_rendered_if_label_is_empty(): void
    {
        $this->assertComponentRenders('', '<x-label />');
    }
}
