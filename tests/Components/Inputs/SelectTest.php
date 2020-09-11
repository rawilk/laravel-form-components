<?php

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

class SelectTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="form-text-container ">
            <select name="country" id="country" class="form-select"></select>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-select name="country" id="country" />'
        );
    }

    /** @test */
    public function it_accepts_an_array_of_options(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-select name="country" :options="['can' => 'Canada', 'usa' => 'United States']" />
        HTML;

        $expected = <<<HTML
        <div class="form-text-container ">
            <select name="country" id="country" class="form-select">
                <option value="can">
                    Canada
                </option>
                <option value="usa">
                    United States
                </option>
            </select>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function options_can_be_pre_selected(): void
    {
        $this->flashOld(['country' => 'usa']);

        $template = <<<HTML
        <x-select name="country" :options="['can' => 'Canada', 'usa' => 'United States']" />
        HTML;

        $expected = <<<HTML
        <div class="form-text-container ">
            <select name="country" id="country" class="form-select">
                <option value="can">
                    Canada
                </option>
                <option value="usa" selected>
                    United States
                </option>
            </select>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function a_default_value_can_be_given(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-select name="country" :options="['can' => 'Canada', 'usa' => 'United States']" value="can" />
        HTML;

        $expected = <<<HTML
        <div class="form-text-container ">
            <select name="country" id="country" class="form-select">
                <option value="can" selected>
                    Canada
                </option>
                <option value="usa">
                    United States
                </option>
            </select>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function custom_attribute_values_can_be_used(): void
    {
        $this->flashOld(['country' => 'usa']);

        // The "value" should be overridden by the flashed old input.
        $template = <<<HTML
        <x-select name="country" id="country_code" class="px-4" value="can" :options="['can' => 'Canada', 'usa' => 'United States']" />
        HTML;

        $expected = <<<HTML
        <div class="form-text-container ">
            <select name="country" id="country_code" class="form-select px-4">
                <option value="can">
                    Canada
                </option>
                <option value="usa" selected>
                    United States
                </option>
            </select>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function can_be_a_multi_select(): void
    {
        $this->flashOld(['country' => ['usa', 'mex']]);

        $template = <<<HTML
        <x-select name="country" multiple :options="['can' => 'Canada', 'usa' => 'United States', 'mex' => 'Mexico']" />
        HTML;

        $expected = <<<HTML
        <div class="form-text-container ">
            <select name="country" id="country" multiple class="form-select">
                <option value="can">
                    Canada
                </option>
                <option value="usa" selected>
                    United States
                </option>
                <option value="mex" selected>
                    Mexico
                </option>
            </select>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function it_indicates_it_has_an_error(): void
    {
        $this->withViewErrors(['country' => 'required']);

        $template = <<<HTML
        <x-select name="country" :options="['can' => 'Canada', 'usa' => 'United States']" />
        HTML;

        $expected = <<<HTML
        <div class="form-text-container ">
            <select name="country" id="country" aria-invalid="true" aria-describedby="country-error" class="form-select input-error">
                <option value="can">
                    Canada
                </option>
                <option value="usa">
                    United States
                </option>
            </select>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
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

        $expected = <<<HTML
        <div class="form-text-container ">
            <select name="country" id="country" class="form-select">
                <option value="ger">Germany</option>
                <option value="can">
                    Canada
                </option>
                <option value="usa" selected>
                    United States
                </option>
                <option value="fra">France</option>
            </select>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }
}
