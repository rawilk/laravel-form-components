<?php

namespace Rawilk\FormComponents\Tests\Components;

class FormGroupTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-form-group label="First name" name="first_name">
            Name input
        </x-form-group>
        HTML;

        $expected = <<<'HTML'
        <div class="form-group">
            <label for="first_name" class="form-label">
                First name
            </label>

            <div class="form-group__content ">
                Name input
            </div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function can_have_help_text(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-form-group label="First name" name="first_name" help-text="Some help text">
            Name field
        </x-form-group>
        HTML;

        $expected = <<<'HTML'
        <div class="form-group">
            <label for="first_name" class="form-label">
                First name
            </label>

            <div class="form-group__content ">
                Name field

                <p class="form-help" id="first_name-description">Some help text</p>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function help_text_can_be_slotted(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-form-group label="First name" name="first_name">
            Name field

            <x-slot name="helpText">
                Some help text
            </x-slot>
        </x-form-group>
        HTML;

        $expected = <<<'HTML'
        <div class="form-group">
            <label for="first_name" class="form-label">
                First name
            </label>

            <div class="form-group__content ">
                Name field

                <p class="form-help" id="first_name-description">Some help text</p>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function can_be_inline(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-form-group label="First name" name="first_name" inline>
            Name field
        </x-form-group>
        HTML;

        $expected = <<<'HTML'
        <div class="form-group form-group-inline">
            <label for="first_name" class="form-label form-group__inline-label">
                First name
            </label>

            <div class="form-group__content form-group__content--inline">
                Name field
            </div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function can_have_a_top_border_when_inline(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-form-group label="First name" name="first_name" inline border>
            Name field
        </x-form-group>
        HTML;

        $expected = <<<'HTML'
        <div class="form-group form-group-inline form-group-inline--border">
            <label for="first_name" class="form-label form-group__inline-label">
                First name
            </label>

            <div class="form-group__content form-group__content--inline">
                Name field
            </div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function can_show_errors(): void
    {
        $this->withViewErrors(['name' => 'Name is required.']);

        $template = <<<'HTML'
        <x-form-group label="First name" name="name">
            Name field
        </x-form-group>
        HTML;

        $expected = <<<'HTML'
        <div class="form-group has-error">
            <label for="name" class="form-label">
                First name
            </label>

            <div class="form-group__content ">
                Name field

                <p class="form-error" id="name-error">
                    Name is required.
                </p>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function inline_checkbox_form_groups_labels_have_no_top_padding(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-form-group label="First name" name="name" inline is-checkbox-group>
            Name field
        </x-form-group>
        HTML;

        $expected = <<<'HTML'
        <div class="form-group form-group-inline">
            <label for="name" class="form-label">
                First name
            </label>

            <div class="form-group__content form-group__content--inline">
                Name field
            </div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function label_can_be_omitted(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-form-group :label="$label" name="name">
            Name field
        </x-form-group>
        HTML;

        $expected = <<<'HTML'
        <div class="form-group">
            <div class="form-group__content ">
                Name field
            </div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template, ['label' => false]);
    }
}
