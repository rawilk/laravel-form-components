<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Support\TimeZoneRegion;
use Rawilk\FormComponents\Tests\Components\ComponentTestCase;
use Spatie\Snapshots\MatchesSnapshots;

class TimezoneSelectTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_be_rendered(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-timezone-select name="timezone" />')
        );
    }

    /** @test */
    public function can_include_just_a_subset_of_timezone_regions(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-timezone-select name="timezone" only="America" />')
        );
    }

    /** @test */
    public function can_include_multiple_region_subsets(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-timezone-select name="timezone" :only="\$only" />
        HTML;

        $regions = [TimeZoneRegion::GENERAL, TimeZoneRegion::ASIA];

        $this->assertMatchesSnapshot($this->renderComponent($template, ['only' => $regions]));
    }

    /** @test */
    public function can_have_a_default_subset_for_only(): void
    {
        $this->withViewErrors([]);

        config(['form-components.timezone_subset' => TimeZoneRegion::GENERAL]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-timezone-select name="timezone" />')
        );
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        $this->withViewErrors([]);

        config(['form-components.timezone_subset' => TimeZoneRegion::GENERAL]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-timezone-select name="timezone" container-class="foo" />')
        );
    }

    /** @test */
    public function name_can_be_omitted(): void
    {
        $this->withViewErrors([]);

        config(['form-components.timezone_subset' => TimeZoneRegion::GENERAL]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-timezone-select />')
        );
    }
}
