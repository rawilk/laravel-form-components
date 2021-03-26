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
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-select name="country" id="countrySelect" />')
        );
    }

    /** @test */
    public function it_accepts_an_array_of_options(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-select name="country" :options="['can' => 'Canada', 'usa' => 'United States']" />
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function options_can_be_pre_selected(): void
    {
        $this->flashOld(['country' => 'usa']);

        $template = <<<HTML
        <x-select name="country" :options="['can' => 'Canada', 'usa' => 'United States']" />
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function a_default_value_can_be_given(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-select name="country" :options="['can' => 'Canada', 'usa' => 'United States']" value="can" />
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function custom_attribute_values_can_be_used(): void
    {
        $this->flashOld(['country' => 'usa']);

        // The "value" should be overridden by the flashed old input.
        $template = <<<HTML
        <x-select name="country" id="country_code" class="px-4" value="can" :options="['can' => 'Canada', 'usa' => 'United States']" />
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function can_be_a_multi_select(): void
    {
        $this->flashOld(['country' => ['usa', 'mex']]);

        $template = <<<HTML
        <x-select name="country" multiple :options="['can' => 'Canada', 'usa' => 'United States', 'mex' => 'Mexico']" />
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function it_indicates_it_has_an_error(): void
    {
        $this->withViewErrors(['country' => 'required']);

        $template = <<<HTML
        <x-select name="country" :options="['can' => 'Canada', 'usa' => 'United States']" />
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function options_can_be_prepended_and_appended(): void
    {
        $this->flashOld(['country' => 'usa']);

        $template = <<<HTML
        <x-select name="country" :options="['can' => 'Canada', 'usa' => 'United States']">
            <option value="ger">Germany</option>

            <x-slot name="append">
                <option value="fra">France</option>
            </x-slot>
        </x-select>
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function name_can_be_omitted(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-select />')
        );
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-select container-class="foo" />')
        );
    }
}
