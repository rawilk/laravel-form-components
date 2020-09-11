<?php

namespace Rawilk\FormComponents\Tests\Components\Choice;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

class RadioTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $expected = <<<HTML
        <div class="choice-container">
            <div class="choice-input">
                <input class="form-radio" name="remember_me" id="remember_me" type="radio" />
            </div>

            <div class="choice-label">
                <label for="remember_me"></label>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-radio name="remember_me" />'
        );
    }

    /** @test */
    public function specific_attributes_can_be_used(): void
    {
        $expected = <<<HTML
        <div class="choice-container">
            <div class="choice-input">
                <input class="form-radio p-4" name="remember_me" id="rememberMe" type="radio" value="remember" />
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
            '<x-radio name="remember_me" id="rememberMe" class="p-4" value="remember" label="Remember me" />'
        );
    }

    /** @test */
    public function label_can_be_slotted(): void
    {
        $expected = <<<HTML
        <div class="choice-container">
            <div class="choice-input">
                <input class="form-radio" name="remember_me" id="remember_me" type="radio" />
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
            '<x-radio name="remember_me">Remember me</x-radio>'
        );
    }

    /** @test */
    public function can_have_old_values(): void
    {
        $this->flashOld(['remember_me' => true]);

        $expected = <<<HTML
        <div class="choice-container">
            <div class="choice-input">
                <input class="form-radio" name="remember_me" id="remember_me" type="radio" checked />
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
            '<x-radio name="remember_me" label="Remember me" />'
        );
    }

    /** @test */
    public function can_have_a_description(): void
    {
        $expected = <<<HTML
        <div class="choice-container">
            <div class="choice-input">
                <input class="form-radio" name="remember_me" id="remember_me" type="radio" />
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
            '<x-radio name="remember_me" label="Remember me" description="My description" />'
        );
    }

    /** @test */
    public function description_can_be_slotted(): void
    {
        $template = <<<HTML
        <x-radio name="remember_me" label="Remember me ">
            <x-slot name="description">
                My <strong>description</strong>
            </x-slot>
        </x-radio>
        HTML;

        $expected = <<<HTML
        <div class="choice-container">
            <div class="choice-input">
                <input class="form-radio" name="remember_me" id="remember_me" type="radio" />
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
        $expected = <<<HTML
        <div class="choice-container">
            <div class="choice-input">
                <input class="form-radio" wire:model="remember" name="remember_me" id="remember_me" type="radio" />
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
            '<x-radio name="remember_me" label="Remember me" wire:model="remember" checked />'
        );
    }
}
