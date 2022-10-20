<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Choice;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;
use Spatie\Snapshots\MatchesSnapshots;

final class SwitchToggleTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_be_rendered(): void
    {
        $this->blade('<x-switch-toggle id="foo" />')
            ->assertSee('id="foo"', false)
            ->assertSee('switch-toggle-button')
            ->assertSee('switch-toggle')
            ->assertSee('x-data')
            ->assertDontSee('@entangle', false);
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        $this->blade('<x-switch-toggle container-class="foo" />')
            ->assertSee('foo');
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
        $template = <<<'HTML'
        <x-switch-toggle id="foo" wire:model="foo" />
        HTML;

        $this->blade('<livewire:blank-livewire-component :template="$template" />', ['template' => $template])
            ->assertSee('value: window.Livewire.find(');
    }

    /** @test */
    public function creates_a_hidden_input_when_a_name_is_used(): void
    {
        $this->blade('<x-switch-toggle name="foo" />')
            ->assertSee('<input', false)
            ->assertSee('type="hidden"', false)
            ->assertSee('name="foo"', false);
    }

    /** @test */
    public function can_have_a_label(): void
    {
        $this->blade('<x-switch-toggle id="foo" label="My label" />')
            ->assertSeeText('My label')
            ->assertSee('switch-toggle-label')
            ->assertSee('x-on:click');
    }

    /** @test */
    public function can_have_a_label_on_the_left(): void
    {
        $this->blade('<x-switch-toggle id="foo" label="My label" label-position="left" />')
            ->assertSeeInOrder([
                'My label',
                '<button',
            ], false);
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

        $this->blade($template)
            ->assertSee('off')
            ->assertSee('on');
    }

    /** @test */
    public function can_be_different_sizes(): void
    {
        $this->blade('<x-switch-toggle id="foo" size="lg" />')
            ->assertSee('switch-toggle--lg');
    }
}
