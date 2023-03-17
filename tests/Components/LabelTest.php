<?php

namespace Rawilk\FormComponents\Tests\Components;

final class LabelTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->blade('<x-label for="first_name" />')
            ->assertSee('<label', false)
            ->assertSeeText('First name')
            ->assertSee('for="first_name"', false)
            ->assertSee('form-label');
    }

    /** @test */
    public function a_custom_label_can_be_used(): void
    {
        $template = <<<'HTML'
        <x-label for="first_name">
            My custom label
        </x-label>
        HTML;

        $this->blade($template)
            ->assertSeeText('My custom label')
            ->assertDontSeeText('First name');
    }

    /** @test */
    public function for_attribute_is_optional(): void
    {
        $this->blade('<x-label>Label...</x-label>')
            ->assertDontSee('for=')
            ->assertSeeText('Label...');
    }

    /** @test */
    public function nothing_is_rendered_if_label_is_empty(): void
    {
        $this->blade('<x-label />')
            ->assertDontSee('<label', false);
    }
}
