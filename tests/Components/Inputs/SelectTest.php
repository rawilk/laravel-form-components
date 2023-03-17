<?php

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class SelectTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->blade('<x-select name="country" id="countrySelect" />')
            ->assertSee('<select', false)
            ->assertSee('name="country"', false)
            ->assertSee('id="countrySelect"', false)
            ->assertSee('form-select');
    }

    /** @test */
    public function it_accepts_an_array_of_options(): void
    {
        $this->blade(
            '<x-select name="country" :options="$options" />',
            ['options' => ['can' => 'Canada', 'usa' => 'United States']],
        )
        ->assertSee('<option', false)
        ->assertSeeInOrder([
            'value="can"',
            'Canada',
            'value="usa"',
            'United States',
        ], false);
    }

    /** @test */
    public function options_can_be_pre_selected(): void
    {
        $this->flashOld(['country' => 'usa']);

        $template = <<<'HTML'
        <x-select name="country" :options="['can' => 'Canada', 'usa' => 'United States']" />
        HTML;

        $this->blade($template)
            ->assertDontSee('<option value="can"  selected', false)
            ->assertSee('<option value="usa"  selected', false);
    }

    /** @test */
    public function a_default_value_can_be_given(): void
    {
        $this->blade(
            '<x-select name="country" :options="$options" :value="$value" />',
            [
                'options' => ['can' => 'Canada', 'usa' => 'United States'],
                'value' => 'can',
            ],
        )
        ->assertSee('value="can"  selected', false)
        ->assertDontSee('value="usa"  selected', false);
    }

    /** @test */
    public function custom_attribute_values_can_be_used(): void
    {
        $this->flashOld(['country' => 'usa']);

        // The "value" should be overridden by the flashed old input.
        $template = <<<'HTML'
        <x-select name="country" id="country_code" class="px-4" value="can" :options="['can' => 'Canada', 'usa' => 'United States']" />
        HTML;

        $this->blade($template)
            ->assertSee('id="country_code"', false)
            ->assertSee('px-4')
            ->assertDontSee('value="can"  selected', false)
            ->assertSee('value="usa"  selected', false);
    }

    /** @test */
    public function can_be_a_multi_select(): void
    {
        $this->flashOld(['country' => ['usa', 'mex']]);

        $template = <<<'HTML'
        <x-select name="country" multiple :options="['can' => 'Canada', 'usa' => 'United States', 'mex' => 'Mexico']" />
        HTML;

        $this->blade($template)
            ->assertSee('<select', false)
            ->assertSee('multiple')
            ->assertSeeInOrder([
                'value="can"',
                'Canada',
                'value="usa"',
                'United States',
                'value="mex"',
                'Mexico',
            ], false)
            ->assertSee('value="usa"  selected', false)
            ->assertSee('value="mex"  selected', false)
            ->assertDontSee('value="can"  selected', false);
    }

    /** @test */
    public function it_indicates_it_has_an_error(): void
    {
        $this->withViewErrors(['country' => 'required']);

        $template = <<<'HTML'
        <x-select name="country" :options="['can' => 'Canada', 'usa' => 'United States']" />
        HTML;

        $this->blade($template)
            ->assertSee('aria-invalid="true"', false)
            ->assertSee('aria-describedby="country-error"', false)
            ->assertSee('input-error');
    }

    /** @test */
    public function options_can_be_prepended_and_appended(): void
    {
        $this->flashOld(['country' => 'usa']);

        $template = <<<'HTML'
        <x-select name="country" :options="['can' => 'Canada', 'usa' => 'United States']">
            <option value="ger">Germany</option>

            <x-slot name="append">
                <option value="fra">France</option>
            </x-slot>
        </x-select>
        HTML;

        $this->blade($template)
            ->assertSeeInOrder([
                'value="ger"',
                'Germany',
                'value="can"',
                'Canada',
                'value="usa"',
                'United States',
                'value="fra"',
                'France',
            ], false);
    }

    /** @test */
    public function name_can_be_omitted(): void
    {
        $this->blade('<x-select />')
            ->assertDontSee('id=')
            ->assertDontSee('name=');
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        $this->blade('<x-select container-class="foo" />')
            ->assertSee('foo');
    }
}
