<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;
use Spatie\Snapshots\MatchesSnapshots;

class PasswordTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_render_component(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-password name="password" />')
        );
    }

    /** @test */
    public function show_toggle_password_can_be_disabled(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-password name="password" :show-toggle="false" />')
        );
    }

    /** @test */
    public function can_have_leading_addon(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-password name="password" leading-addon="foo" />')
        );
    }

    /** @test */
    public function it_ignores_trailing_addons(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-password name="password" :show-toggle="false" trailing-addon="foo" />')
        );
    }

    /** @test */
    public function slotted_trailing_addons_are_ignored(): void
    {
        $this->withViewErrors([]);

        // Even if we try to specify a trailing addon, the component should render its toggle trailing addon instead.
        $template = <<<'HTML'
        <x-password name="password" leading-addon="foo">
            <x-slot name="trailingAddon">foo</x-slot>
        </x-password>
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-password :show-toggle="false" name="name" container-class="foo" />')
        );
    }

    /** @test */
    public function name_can_be_omitted(): void
    {
        $this->withViewErrors([]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-password :show-toggle="false" />')
        );
    }
}
