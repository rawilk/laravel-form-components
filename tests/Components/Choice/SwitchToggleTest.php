<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Choice;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

class SwitchToggleTest extends ComponentTestCase
{
    private null|string $buttonLabel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->buttonLabel = __('form-components::messages.switch_button_label');
    }

    /** @test */
    public function can_be_rendered(): void
    {
        $expected = <<<HTML
        <div x-data="{
            onValue: true,
            offValue: false,
            value: false,
            get isPressed() {
                return this.value === this.onValue;
            },
            toggle() {
                this.value = this.isPressed ? this.offValue : this.onValue;
            },
        }"
        wire:ignore.self
        class="flex items-center">
            <button x-bind:aria-pressed="JSON.stringify(isPressed)"
                    x-on:click="toggle()"
                    x-ref="button"
                    x-cloak
                    type="button"
                    id="foo"
                    class="switch-toggle switch-toggle-simple"
                    x-bind:class="{ 'pressed': isPressed }">
                <span class="sr-only">{$this->buttonLabel}</span>

                <span aria-hidden="true"
                      class="switch-toggle-button"
                      x-bind:class="{ 'pressed': isPressed }">
                </span>
            </button>
        </div>
        HTML;

        $this->assertComponentRenders($expected, '<x-switch-toggle id="foo" />');
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        $expected = <<<HTML
        <div x-data="{
            onValue: true,
            offValue: false,
            value: false,
            get isPressed() {
                return this.value === this.onValue;
            },
            toggle() {
                this.value = this.isPressed ? this.offValue : this.onValue;
            },
        }"
        wire:ignore.self
        class="flex items-center foo">
            <button x-bind:aria-pressed="JSON.stringify(isPressed)"
                    x-on:click="toggle()"
                    x-ref="button"
                    x-cloak
                    type="button"
                    id="foo"
                    class="switch-toggle switch-toggle-simple"
                    x-bind:class="{ 'pressed': isPressed }">
                <span class="sr-only">{$this->buttonLabel}</span>

                <span aria-hidden="true"
                      class="switch-toggle-button"
                      x-bind:class="{ 'pressed': isPressed }">
                </span>
            </button>
        </div>
        HTML;

        $this->assertComponentRenders($expected, '<x-switch-toggle id="foo" container-class="foo" />');
    }

    /** @test */
    public function custom_attributes_are_applied_to_the_button(): void
    {
        $expected = <<<HTML
        <div x-data="{
            onValue: true,
            offValue: false,
            value: false,
            get isPressed() {
                return this.value === this.onValue;
            },
            toggle() {
                this.value = this.isPressed ? this.offValue : this.onValue;
            },
        }"
        wire:ignore.self
        class="flex items-center">
            <button x-bind:aria-pressed="JSON.stringify(isPressed)"
                    x-on:click="toggle()"
                    x-ref="button"
                    x-cloak
                    type="button"
                    id="foo"
                    class="switch-toggle switch-toggle-simple foo-class"
                    data-foo="bar"
                    x-bind:class="{ 'pressed': isPressed }">
                <span class="sr-only">{$this->buttonLabel}</span>

                <span aria-hidden="true"
                      class="switch-toggle-button"
                      x-bind:class="{ 'pressed': isPressed }">
                </span>
            </button>
        </div>
        HTML;

        $this->assertComponentRenders($expected, '<x-switch-toggle id="foo" class="foo-class" data-foo="bar" />');
    }

    /** @test */
    public function can_have_a_wire_model_instead_of_value(): void
    {
        // In an actual livewire component, the @entangle would be replaced...
        $expected = <<<HTML
        <div x-data="{
            onValue: true,
            offValue: false,
            value: @entangle(\$attributes-> wire('model')),
            get isPressed() {
                return this.value === this.onValue;
            },
            toggle() {
                this.value = this.isPressed ? this.offValue : this.onValue;
            },
        }"
        wire:ignore.self
        class="flex items-center">
            <button x-bind:aria-pressed="JSON.stringify(isPressed)"
                    x-on:click="toggle()"
                    x-ref="button"
                    x-cloak
                    type="button"
                    id="foo"
                    class="switch-toggle switch-toggle-simple"
                    x-bind:class="{ 'pressed': isPressed }">
                <span class="sr-only">{$this->buttonLabel}</span>

                <span aria-hidden="true"
                      class="switch-toggle-button"
                      x-bind:class="{ 'pressed': isPressed }">
                </span>
            </button>
        </div>
        HTML;

        $this->assertComponentRenders($expected, '<x-switch-toggle id="foo" wire:model="foo" />');
    }

    /** @test */
    public function creates_a_hidden_input_when_a_name_is_used(): void
    {
        $expected = <<<HTML
        <div x-data="{
            onValue: true,
            offValue: false,
            value: false,
            get isPressed() {
                return this.value === this.onValue;
            },
            toggle() {
                this.value = this.isPressed ? this.offValue : this.onValue;
            },
        }"
        wire:ignore.self
        class="flex items-center">
            <button x-bind:aria-pressed="JSON.stringify(isPressed)"
                    x-on:click="toggle()"
                    x-ref="button"
                    x-cloak
                    type="button"
                    id="foo"
                    class="switch-toggle switch-toggle-simple"
                    x-bind:class="{ 'pressed': isPressed }">
                <span class="sr-only">{$this->buttonLabel}</span>

                <span aria-hidden="true"
                      class="switch-toggle-button"
                      x-bind:class="{ 'pressed': isPressed }">
                </span>
            </button>

            <input type="hidden" name="foo" x-bind:value="JSON.stringify(value)" />
        </div>
        HTML;

        $this->assertComponentRenders($expected, '<x-switch-toggle name="foo" />');
    }

    /** @test */
    public function can_have_a_label(): void
    {
        $expected = <<<HTML
        <div x-data="{
            onValue: true,
            offValue: false,
            value: false,
            get isPressed() {
                return this.value === this.onValue;
            },
            toggle() {
                this.value = this.isPressed ? this.offValue : this.onValue;
            },
        }"
        wire:ignore.self
        class="flex items-center">
            <button x-bind:aria-pressed="JSON.stringify(isPressed)"
                    x-on:click="toggle()"
                    x-ref="button"
                    x-cloak
                    type="button"
                    id="foo"
                    aria-labelledby="foo-label"
                    class="switch-toggle switch-toggle-simple"
                    x-bind:class="{ 'pressed': isPressed }">
                <span class="sr-only">{$this->buttonLabel}</span>

                <span aria-hidden="true"
                      class="switch-toggle-button"
                      x-bind:class="{ 'pressed': isPressed }">
                </span>
            </button>

            <span x-on:click="\$refs.button.click(); \$refs.button.focus()"
                  class="ml-3 switch-toggle-label form-label"
                  id="foo-label">
                my label
            </span>
        </div>
        HTML;

        $this->assertComponentRenders($expected, '<x-switch-toggle id="foo" label="my label" />');
    }

    /** @test */
    public function can_have_a_label_on_the_left(): void
    {
        $expected = <<<HTML
        <div x-data="{
            onValue: true,
            offValue: false,
            value: false,
            get isPressed() {
                return this.value === this.onValue;
            },
            toggle() {
                this.value = this.isPressed ? this.offValue : this.onValue;
            },
        }"
        wire:ignore.self
        class="flex items-center justify-between">
            <span x-on:click="\$refs.button.click(); \$refs.button.focus();"
                  class="flex-grow switch-toggle-label form-label"
                  id="foo-label">
                my label
            </span>

            <button x-bind:aria-pressed="JSON.stringify(isPressed)"
                    x-on:click="toggle()"
                    x-ref="button"
                    x-cloak
                    type="button"
                    id="foo"
                    aria-labelledby="foo-label"
                    class="switch-toggle switch-toggle-simple"
                    x-bind:class="{ 'pressed': isPressed }">
                <span class="sr-only">{$this->buttonLabel}</span>

                <span aria-hidden="true"
                      class="switch-toggle-button"
                      x-bind:class="{ 'pressed': isPressed }">
                </span>
            </button>
        </div>
        HTML;

        $this->assertComponentRenders($expected, '<x-switch-toggle id="foo" label="my label" label-position="left" />');
    }

    /** @test */
    public function can_have_on_and_off_state_icons(): void
    {
        $template = <<<HTML
        <x-switch-toggle id="foo">
            <x-slot name="offIcon">off</x-slot>
            <x-slot name="onIcon">on</x-slot>
        </x-switch-toggle>
        HTML;

        $expected = <<<HTML
        <div x-data="{
            onValue: true,
            offValue: false,
            value: false,
            get isPressed() {
                return this.value === this.onValue;
            },
            toggle() {
                this.value = this.isPressed ? this.offValue : this.onValue;
            },
        }"
        wire:ignore.self
        class="flex items-center">
            <button x-bind:aria-pressed="JSON.stringify(isPressed)"
                    x-on:click="toggle()"
                    x-ref="button"
                    x-cloak
                    type="button"
                    id="foo"
                    class="switch-toggle switch-toggle-simple"
                    x-bind:class="{ 'pressed': isPressed }">
                <span class="sr-only">{$this->buttonLabel}</span>

                <span aria-hidden="true"
                      class="switch-toggle-button"
                      x-bind:class="{ 'pressed': isPressed }">
                      <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity"
                            x-bind:class="{ 'opacity-0 ease-out duration-100': isPressed, 'opacity-100 ease-in duration-200': ! isPressed }"
                            aria-hidden="true">
                          off
                      </span>
                      <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity"
                            x-bind:class="{ 'opacity-100 ease-in duration-200': isPressed, 'opacity-0 ease-out duration-100': ! isPressed }"
                            aria-hidden="true">
                          on
                      </span>
                </span>
            </button>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function can_be_different_sizes(): void
    {
        $expected = <<<HTML
        <div x-data="{
            onValue: true,
            offValue: false,
            value: false,
            get isPressed() {
                return this.value === this.onValue;
            },
            toggle() {
                this.value = this.isPressed ? this.offValue : this.onValue;
            },
        }"
        wire:ignore.self
        class="flex items-center">
            <button x-bind:aria-pressed="JSON.stringify(isPressed)"
                    x-on:click="toggle()"
                    x-ref="button"
                    x-cloak
                    type="button"
                    id="foo"
                    class="switch-toggle switch-toggle-simple switch-toggle--lg"
                    x-bind:class="{ 'pressed': isPressed }">
                <span class="sr-only">{$this->buttonLabel}</span>

                <span aria-hidden="true"
                      class="switch-toggle-button"
                      x-bind:class="{ 'pressed': isPressed }">
                </span>
            </button>
        </div>
        HTML;

        $this->assertComponentRenders($expected, '<x-switch-toggle id="foo" size="lg" />');
    }
}
