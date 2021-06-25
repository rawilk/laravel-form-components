<?php

namespace Rawilk\FormComponents\Tests\Components;

use Spatie\Snapshots\MatchesSnapshots;

class FormGroupTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_be_rendered(): void
    {
        $template = <<<HTML
        <x-form-group label="First name" name="first_name">
            Name input
        </x-form-group>
        HTML;

        $this->assertMatchesSnapshot(
            (string) $this->blade($template)
        );
    }

    /** @test */
    public function can_have_help_text(): void
    {
        $template = <<<HTML
        <x-form-group label="First name" name="first_name" help-text="Some help text">
            Name field
        </x-form-group>
        HTML;

        $this->assertMatchesSnapshot(
            (string) $this->blade($template)
        );
    }

    /** @test */
    public function help_text_can_be_slotted(): void
    {
        $template = <<<HTML
        <x-form-group label="First name" name="first_name">
            Name field

            <x-slot name="helpText">
                Some help text
            </x-slot>
        </x-form-group>
        HTML;

        $this->assertMatchesSnapshot(
            (string) $this->blade($template)
        );
    }

    /** @test */
    public function can_be_inline(): void
    {
        $template = <<<HTML
        <x-form-group label="First name" name="first_name" inline>
            Name field
        </x-form-group>
        HTML;

        $this->assertMatchesSnapshot(
            (string) $this->blade($template)
        );
    }

    /** @test */
    public function border_top_can_be_disabled_when_inline(): void
    {
        $template = '<x-form-group label="First name" name="first_name" inline :border="$border">Name field</x-form-group>';

        $this->assertMatchesSnapshot(
            (string) $this->blade($template, ['border' => false])
        );
    }

    /** @test */
    public function can_show_errors(): void
    {
        $this->withViewErrors(['name' => 'Name is required.']);

        $template = <<<HTML
        <x-form-group label="First name" name="name">
            Name field
        </x-form-group>
        HTML;

        $this->assertMatchesSnapshot(
            (string) $this->blade($template)
        );
    }

    /** @test */
    public function inline_checkbox_form_groups_labels_have_no_top_padding(): void
    {
        $template = <<<HTML
        <x-form-group label="First name" name="name" inline is-checkbox-group>
            Name field
        </x-form-group>
        HTML;

        $this->assertMatchesSnapshot(
            (string) $this->blade($template)
        );
    }

    /** @test */
    public function label_can_be_omitted(): void
    {
        $template = <<<HTML
        <x-form-group :label="\$label" name="name">
            Name field
        </x-form-group>
        HTML;

        $this->assertMatchesSnapshot(
            (string) $this->blade($template, ['label' => false])
        );
    }

    /** @test */
    public function can_have_optional_help_text(): void
    {
        config()->set('form-components.optional_hint_text', 'Optional');

        $template = <<<HTML
        <x-form-group name="foo" optional>
            <x-input name="foo" aria-describedby="foo-hint" />
        </x-form-group>
        HTML;

        $this->assertMatchesSnapshot((string) $this->blade($template));
    }

    /** @test */
    public function can_have_optional_hint_when_inline(): void
    {
        config()->set('form-components.optional_hint_text', 'Optional');

        $template = <<<HTML
        <x-form-group name="foo" optional inline>
            <x-input name="foo" aria-describedby="foo-hint foo-hint-inline" />
        </x-form-group>
        HTML;

        $this->assertMatchesSnapshot((string) $this->blade($template));
    }

    /** @test */
    public function can_have_custom_hint_text(): void
    {
        $template = <<<HTML
        <x-form-group name="foo" hint="My hint text">
            <x-input name="foo" aria-describedby="foo-hint" />
        </x-form-group>
        HTML;

        $this->assertMatchesSnapshot((string) $this->blade($template));
    }
}
