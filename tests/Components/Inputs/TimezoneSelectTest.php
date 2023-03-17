<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Support\TimeZoneRegion;
use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

class TimezoneSelectTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="form-text-container ">
            <select name="timezone" id="timezone" class="form-select">
                {$this->generateTimezoneOptions()}
            </select>
        </div>
        HTML;

        $this->assertComponentRenders($expected, '<x-timezone-select name="timezone" />');
    }

    /** @test */
    public function can_include_just_a_subset_of_timezone_regions(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-timezone-select name="timezone" only="America" />
        HTML;

        $expected = <<<HTML
        <div class="form-text-container ">
            <select name="timezone" id="timezone" class="form-select">
                {$this->generateTimezoneOptions(['America'])}
            </select>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function can_include_multiple_region_subsets(): void
    {
        $this->withViewErrors([]);

        $template = <<<'HTML'
        <x-timezone-select name="timezone" :only="$only" />
        HTML;

        $regions = [TimeZoneRegion::GENERAL, TimeZoneRegion::ASIA];

        $expected = <<<HTML
        <div class="form-text-container ">
            <select name="timezone" id="timezone" class="form-select">
                {$this->generateTimezoneOptions($regions)}
            </select>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template, ['only' => $regions]);
    }

    /** @test */
    public function can_have_a_default_subset_for_only(): void
    {
        $this->withViewErrors([]);

        config(['form-components.timezone_subset' => TimeZoneRegion::GENERAL]);

        $template = <<<'HTML'
        <x-timezone-select name="timezone" />
        HTML;

        $expected = <<<'HTML'
        <div class="form-text-container ">
            <select name="timezone" id="timezone" class="form-select">
                <optgroup label="General">
                    <option value="GMT">GMT</option>
                    <option value="UTC">UTC</option>
                </optgroup>
            </select>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    private function generateTimezoneOptions($only = false)
    {
        $timezones = app('fc-timezone')->only($only)->all();

        $html = '';

        foreach ($timezones as $region => $regionTimezones) {
            $html .= <<<HTML
            <optgroup label="{$region}">\n
            HTML;

            foreach ($regionTimezones as $key => $display) {
                $html .= <<<HTML
                <option value="{$key}">{$display}</option>\n
                HTML;
            }

            $html .= "</optgroup>\n";
        }

        return $html;
    }
}
