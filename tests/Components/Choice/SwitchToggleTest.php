<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Choice;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;
use Spatie\Snapshots\MatchesSnapshots;

class SwitchToggleTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_be_rendered(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-switch-toggle id="foo" />')
        );
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-switch-toggle id="foo" container-class="foo" />')
        );
    }

    /** @test */
    public function custom_attributes_are_applied_to_the_button(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-switch-toggle id="foo" class="foo-class" data-foo="bar" />')
        );
    }

    /** @test */
    public function can_have_a_wire_model_instead_of_value(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-switch-toggle id="foo" wire:model="foo" />')
        );
    }

    /** @test */
    public function creates_a_hidden_input_when_a_name_is_used(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-switch-toggle name="foo" />')
        );
    }

    /** @test */
    public function can_have_a_label(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-switch-toggle id="foo" label="My label" />')
        );
    }

    /** @test */
    public function can_have_a_label_on_the_left(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-switch-toggle id="foo" label="My label" label-position="left" />')
        );
    }

    /** @test */
    public function can_have_on_and_off_state_icons(): void
    {
        $template = <<<'HTML'
        <x-switch-toggle id="foo">
            <x-slot name="offIcon">off</x-slot>
            <x-slot name="onIcon">on</x-slot>
        </x-switch-toggle>
        HTML;

        $this->assertMatchesSnapshot((string) $this->blade($template));
    }

    /** @test */
    public function can_be_different_sizes(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-switch-toggle id="foo" size="lg" />')
        );
    }
}
