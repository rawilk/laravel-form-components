<?php

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;
use Spatie\Snapshots\MatchesSnapshots;

class SelectTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_be_rendered(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-select name="country" id="countrySelect" />')
        );
    }

    /** @test */
    public function it_accepts_an_array_of_options(): void
    {
        $view = $this->blade(
            '<x-select name="country" :options="$options" />',
            ['options' => ['can' => 'Canada', 'usa' => 'United States']],
        );

        $this->assertMatchesSnapshot((string) $view);
    }

    /** @test */
    public function options_can_be_pre_selected(): void
    {
        $this->flashOld(['country' => 'usa']);

        $template = <<<'HTML'
        <x-select name="country" :options="['can' => 'Canada', 'usa' => 'United States']" />
        HTML;

        $this->assertMatchesSnapshot((string) $this->blade($template));
    }

    /** @test */
    public function a_default_value_can_be_given(): void
    {
        $view = $this->blade(
            '<x-select name="country" :options="$options" :value="$value" />',
            [
                'options' => ['can' => 'Canada', 'usa' => 'United States'],
                'value' => 'can',
            ]
        );

        $this->assertMatchesSnapshot((string) $view);
    }

    /** @test */
    public function custom_attribute_values_can_be_used(): void
    {
        $this->flashOld(['country' => 'usa']);

        // The "value" should be overridden by the flashed old input.
        $template = <<<'HTML'
        <x-select name="country" id="country_code" class="px-4" value="can" :options="['can' => 'Canada', 'usa' => 'United States']" />
        HTML;

        $this->assertMatchesSnapshot((string) $this->blade($template));
    }

    /** @test */
    public function can_be_a_multi_select(): void
    {
        $this->flashOld(['country' => ['usa', 'mex']]);

        $template = <<<'HTML'
        <x-select name="country" multiple :options="['can' => 'Canada', 'usa' => 'United States', 'mex' => 'Mexico']" />
        HTML;

        $this->assertMatchesSnapshot((string) $this->blade($template));
    }

    /** @test */
    public function it_indicates_it_has_an_error(): void
    {
        $this->withViewErrors(['country' => 'required']);

        $template = <<<'HTML'
        <x-select name="country" :options="['can' => 'Canada', 'usa' => 'United States']" />
        HTML;

        $this->assertMatchesSnapshot((string) $this->blade($template));
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

        $this->assertMatchesSnapshot((string) $this->blade($template));
    }

    /** @test */
    public function name_can_be_omitted(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-select />')
        );
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-select container-class="foo" />')
        );
    }
}
