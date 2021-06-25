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
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-timezone-select name="timezone" only="General" />')
        );
    }

    /** @test */
    public function can_include_just_a_subset_of_timezone_regions(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-timezone-select name="timezone" only="General" />')
        );
    }

    /** @test */
    public function can_include_multiple_region_subsets(): void
    {
        $regions = [TimeZoneRegion::GENERAL, TimeZoneRegion::AMERICA];

        $view = $this->blade(
            '<x-timezone-select name="timezone" :only="$only" />',
            ['only' => $regions],
        );

        $view->assertSee('UTC')
            ->assertSee('America/Chicago')
            ->assertDontSee('Europe/London');
    }

    /** @test */
    public function can_have_a_default_subset_for_only(): void
    {
        config(['form-components.timezone_subset' => TimeZoneRegion::GENERAL]);

        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-timezone-select name="timezone" />')
        );
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        config(['form-components.timezone_subset' => TimeZoneRegion::GENERAL]);

        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-timezone-select name="timezone" container-class="foo" />')
        );
    }

    /** @test */
    public function name_can_be_omitted(): void
    {
        config(['form-components.timezone_subset' => TimeZoneRegion::GENERAL]);

        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-timezone-select />')
        );
    }
}
