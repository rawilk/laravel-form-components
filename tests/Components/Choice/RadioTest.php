<?php

namespace Rawilk\FormComponents\Tests\Components\Choice;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;
use Spatie\Snapshots\MatchesSnapshots;

class RadioTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_be_rendered(): void
    {
        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-radio name="remember_me" />')
        );
    }

    /** @test */
    public function specific_attributes_can_be_used(): void
    {
        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-radio name="remember_me" id="rememberMe" class="p-4" value="remember" label="Remember me" />')
        );
    }

    /** @test */
    public function label_can_be_slotted(): void
    {
        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-radio name="remember_me">Remember me</x-radio>')
        );
    }

    /** @test */
    public function can_have_old_values(): void
    {
        $this->flashOld(['remember_me' => true]);

        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-radio name="remember_me" label="Remember me" />')
        );
    }

    /** @test */
    public function can_have_a_description(): void
    {
        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-radio name="remember_me" label="Remember me" description="My description" />')
        );
    }

    /** @test */
    public function description_can_be_slotted(): void
    {
        $template = <<<'HTML'
        <x-radio name="remember_me" label="Remember me">
            <x-slot name="description">
                My <strong>description</strong>
            </x-slot>
        </x-radio>
        HTML;

        $this->assertMatchesSnapshot($this->renderComponent($template));
    }

    /** @test */
    public function checked_is_not_rendered_if_wire_model_is_present(): void
    {
        $this->assertMatchesSnapshot(
            $this->renderComponent('<x-radio name="remember_me" label="Remember me" wire:model="remember" checked />')
        );
    }
}
