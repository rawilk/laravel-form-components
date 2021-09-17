<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Support\TimeZoneRegion;
use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class TimezoneSelectTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->blade('<x-timezone-select name="timezone" />')
            ->assertSee('<select', false)
            ->assertSee('name="timezone"', false)
            ->assertSee('GMT')
            ->assertSee('UTC')
            ->assertSee('America/Chicago');
    }

    /** @test */
    public function can_include_just_a_subset_of_timezone_regions(): void
    {
        $this->blade('<x-timezone-select name="timezone" only="General" />')
            ->assertSee('UTC')
            ->assertDontSee('America/Chicago');
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

        $this->blade('<x-timezone-select name="timezone" />')
            ->assertSee('UTC')
            ->assertDontSee('America/Chicago');
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        $this->blade('<x-timezone-select name="timezone" container-class="foo" />')
            ->assertSee('foo');
    }

    /** @test */
    public function name_can_be_omitted(): void
    {
        $this->blade('<x-timezone-select />')
            ->assertDontSee('name=')
            ->assertDontSee('id=');
    }
}
