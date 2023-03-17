<?php

namespace Rawilk\FormComponents\Tests\Components\Choice;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

class CheckboxTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $expected = <<<'HTML'
        <div class="choice-container">
            <div class="choice-input">
                <input class="form-checkbox" name="remember_me" id="remember_me" type="checkbox" />
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-checkbox name="remember_me" />'
        );
    }

    /** @test */
    public function specific_attributes_can_be_used(): void
    {
        $expected = <<<'HTML'
        <div class="choice-container">
            <div class="choice-input">
                <input class="form-checkbox p-4" name="remember_me" id="rememberMe" type="checkbox" value="remember" />
            </div>

            <div class="choice-label">
                <label for="rememberMe">
                    Remember me
                </label>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-checkbox name="remember_me" id="rememberMe" class="p-4" value="remember" label="Remember me" />'
        );
    }

    /** @test */
    public function label_can_be_slotted(): void
    {
        $expected = <<<'HTML'
        <div class="choice-container">
            <div class="choice-input">
                <input class="form-checkbox" name="remember_me" id="remember_me" type="checkbox" />
            </div>

            <div class="choice-label">
                <label for="remember_me">
                    Remember me
                </label>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-checkbox name="remember_me">Remember me</x-checkbox>'
        );
    }

    /** @test */
    public function can_have_old_values(): void
    {
        $this->flashOld(['remember_me' => true]);

        $expected = <<<'HTML'
        <div class="choice-container">
            <div class="choice-input">
                <input class="form-checkbox" name="remember_me" id="remember_me" type="checkbox" checked />
            </div>

            <div class="choice-label">
                <label for="remember_me">
                    Remember me
                </label>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-checkbox name="remember_me" label="Remember me" />'
        );
    }

    /** @test */
    public function can_have_a_description(): void
    {
        $expected = <<<'HTML'
        <div class="choice-container">
            <div class="choice-input">
                <input class="form-checkbox" name="remember_me" id="remember_me" type="checkbox" />
            </div>

            <div class="choice-label">
                <label for="remember_me">
                    Remember me
                </label>

                <p class="choice-description">My description</p>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-checkbox name="remember_me" label="Remember me" description="My description" />'
        );
    }

    /** @test */
    public function description_can_be_slotted(): void
    {
        $template = <<<'HTML'
        <x-checkbox name="remember_me" label="Remember me ">
            <x-slot name="description">
                My <strong>description</strong>
            </x-slot>
        </x-checkbox>
        HTML;

        $expected = <<<'HTML'
        <div class="choice-container">
            <div class="choice-input">
                <input class="form-checkbox" name="remember_me" id="remember_me" type="checkbox" />
            </div>

            <div class="choice-label">
                <label for="remember_me">
                    Remember me
                </label>

                <p class="choice-description">My <strong>description</strong></p>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function checked_is_not_rendered_if_wire_model_is_present(): void
    {
        $expected = <<<'HTML'
        <div class="choice-container">
            <div class="choice-input">
                <input class="form-checkbox" wire:model="remember" name="remember_me" id="remember_me" type="checkbox" />
            </div>

            <div class="choice-label">
                <label for="remember_me">
                    Remember me
                </label>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-checkbox name="remember_me" label="Remember me" wire:model="remember" checked />'
        );
    }
}
