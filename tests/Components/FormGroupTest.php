<?php

namespace Rawilk\FormComponents\Tests\Components;

final class FormGroupTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $template = <<<'HTML'
        <x-form-group label="First name" name="first_name">
            Name input
        </x-form-group>
        HTML;

        $this->blade($template)
            ->assertSeeText('First name')
            ->assertSee('Name input')
            ->assertSee('form-group')
            ->assertSee('<label', false)
            ->assertSee('for="first_name"', false)
            ->assertSee('form-group__content');
    }

    /** @test */
    public function can_have_help_text(): void
    {
        $template = <<<'HTML'
        <x-form-group label="First name" name="first_name" help-text="Some help text">
            Name field
        </x-form-group>
        HTML;

        $this->blade($template)
            ->assertSeeText('Some help text')
            ->assertSee('first_name-description')
            ->assertSee('form-help');
    }

    /** @test */
    public function help_text_can_be_slotted(): void
    {
        $template = <<<'HTML'
        <x-form-group label="First name" name="first_name">
            Name field

            <x-slot name="helpText">
                Some help text
            </x-slot>
        </x-form-group>
        HTML;

        $this->blade($template)
            ->assertSeeText('Some help text');
    }

    /** @test */
    public function can_be_inline(): void
    {
        $template = <<<'HTML'
        <x-form-group label="First name" name="first_name" inline>
            Name field
        </x-form-group>
        HTML;

        $this->blade($template)
            ->assertSee('form-group-inline')
            ->assertSee('form-group__content--inline')
            ->assertSee('border-t');
    }

    /** @test */
    public function border_top_can_be_disabled_when_inline(): void
    {
        $template = '<x-form-group label="First name" name="first_name" inline :border="false">Name field</x-form-group>';

        $this->blade($template)
            ->assertDontSee('border-t');
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

        $this->blade($template)
            ->assertSeeText('Name is required.')
            ->assertSee('id="name-error"', false)
            ->assertSee('form-error')
            ->assertSee('has-error');
    }

    /** @test */
    public function inline_checkbox_form_groups_labels_have_no_top_padding(): void
    {
        $template = <<<'HTML'
        <x-form-group label="First name" name="name" inline is-checkbox-group>
            Name field
        </x-form-group>
        HTML;

        $this->blade($template)
            ->assertDontSee('form-group__inline-label');
    }

    /** @test */
    public function label_can_be_omitted(): void
    {
        $template = <<<'HTML'
        <x-form-group :label="false" name="name">
            Name field
        </x-form-group>
        HTML;

        $this->blade($template)
            ->assertDontSee('<label', false);
    }

    /** @test */
    public function can_have_optional_help_text(): void
    {
        config()->set('form-components.optional_hint_text', 'Optional');

        $template = <<<'HTML'
        <x-form-group name="foo" optional>
            <x-input name="foo" aria-describedby="foo-hint" />
        </x-form-group>
        HTML;

        $this->blade($template)
            ->assertSeeText('Optional')
            ->assertSee('id="foo-hint"', false);
    }

    /** @test */
    public function can_have_optional_hint_when_inline(): void
    {
        config()->set('form-components.optional_hint_text', 'Optional');

        $template = <<<'HTML'
        <x-form-group name="foo" optional inline>
            <x-input name="foo" aria-describedby="foo-hint foo-hint-inline" />
        </x-form-group>
        HTML;

        $this->blade($template)
            ->assertSeeText('Optional')
            ->assertSee('id="foo-hint"', false)
            ->assertSee('id="foo-hint-inline"', false);
    }

    /** @test */
    public function can_have_custom_hint_text(): void
    {
        $template = <<<'HTML'
        <x-form-group name="foo" hint="My hint text">
            <x-input name="foo" aria-describedby="foo-hint" />
        </x-form-group>
        HTML;

        $this->blade($template)
            ->assertSeeText('My hint text')
            ->assertSee('id="foo-hint"', false);
    }
}
