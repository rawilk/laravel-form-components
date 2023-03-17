<?php

namespace Rawilk\FormComponents\Tests\Components\Choice;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class CheckboxTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->blade('<x-checkbox name="remember_me" />')
            ->assertSee('<input', false)
            ->assertSee('name="remember_me"', false)
            ->assertSee('type="checkbox"', false)
            ->assertSee('form-checkbox');
    }

    /** @test */
    public function specific_attributes_can_be_used(): void
    {
        $this->blade('<x-checkbox name="remember_me" id="rememberMe" class="p-4" value="remember" label="Remember me" />')
            ->assertSeeText('Remember me')
            ->assertSee('name="remember_me"', false)
            ->assertSee('id="rememberMe"', false)
            ->assertSee('p-4')
            ->assertSee('form-checkbox')
            ->assertSee('value="remember"', false)
            ->assertSee('<label', false)
            ->assertSee('choice-label')
            ->assertSee('for="rememberMe"', false);
    }

    /** @test */
    public function label_can_be_slotted(): void
    {
        $this->blade('<x-checkbox name="remember_me">Remember me</x-checkbox>')
            ->assertSeeText('Remember me')
            ->assertSee('<label', false)
            ->assertSee('for="remember_me"', false);
    }

    /** @test */
    public function can_have_old_values(): void
    {
        $this->flashOld(['remember_me' => true]);

        $this->blade('<x-checkbox name="remember_me" label="Remember me" />')
            ->assertSee('checked');

        $this->flashOld(['remember_me' => false]);

        $this->blade('<x-checkbox name="remember_me" label="Remember me" />')
            ->assertDontSee('checked');
    }

    /** @test */
    public function can_have_a_description(): void
    {
        $this->blade('<x-checkbox name="remember_me" label="Remember me" description="My description" />')
            ->assertSeeText('My description')
            ->assertSeeText('Remember me')
            ->assertSee('choice-description');
    }

    /** @test */
    public function description_can_be_slotted(): void
    {
        $template = <<<'HTML'
        <x-checkbox name="remember_me" label="Remember me">
            <x-slot name="description">
                My <strong>description</strong>
            </x-slot>
        </x-checkbox>
        HTML;

        $this->blade($template)
            ->assertSee('My <strong>description</strong>', false)
            ->assertSee('choice-description');
    }

    /** @test */
    public function checked_is_not_rendered_if_wire_model_is_present(): void
    {
        $this->blade('<x-checkbox name="remember_me" label="Remember me" wire:model="remember" checked />')
            ->assertDontSee('checked')
            ->assertSee('wire:model');
    }
}
