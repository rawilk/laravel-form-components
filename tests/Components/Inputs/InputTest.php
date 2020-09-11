<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Components\Inputs\Input;
use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

class InputTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="form-text-container ">
            <input class="form-input form-text" name="search" id="search" type="text" />
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-input name="search" />'
        );
    }

    /** @test */
    public function specific_attributes_can_be_overwritten(): void
    {
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="form-text-container ">
            <input class="form-input form-text p-4" name="confirm_password" id="confirmPassword" type="password" />
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-input name="confirm_password" id="confirmPassword" type="password" class="p-4" />'
        );
    }

    /** @test */
    public function inputs_can_have_old_values(): void
    {
        $this->flashOld(['search' => 'Eloquent']);
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="form-text-container ">
            <input class="form-input form-text" name="search" id="search" type="text" value="Eloquent" />
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-input name="search" />'
        );
    }

    /** @test */
    public function does_not_add_value_attribute_if_wire_model_present(): void
    {
        $this->flashOld(['search' => 'Eloquent']);
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="form-text-container ">
            <input class="form-input form-text" wire:model="search" name="search" id="search" type="text" />
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-input name="search" wire:model="search" />'
        );
    }

    /** @test */
    public function can_have_leading_addon(): void
    {
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="form-text-container ">
            <span class="leading-addon">foo</span>

            <input class="form-input form-text has-leading-addon" name="search" id="search" type="text" />
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-input name="search" leading-addon="foo" />'
        );
    }

    /** @test */
    public function leading_addon_can_be_slotted(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-input name="search">
            <x-slot name="leadingAddon">foo</x-slot>
        </x-input>
        HTML;

        $expected = <<<HTML
        <div class="form-text-container ">
            <span class="leading-addon">foo</span>

            <input class="form-input form-text has-leading-addon" name="search" id="search" type="text" />
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function can_have_inline_addon(): void
    {
        $this->withViewErrors([]);

        $padding = Input::DEFAULT_INLINE_ADDON_PADDING;

        $expected = <<<HTML
        <div class="form-text-container ">
            <div class="inline-addon">
                <span>foo</span>
            </div>

            <input class="form-input form-text {$padding}" name="search" id="search" type="text" />
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-input name="search" inline-addon="foo" />'
        );

        // With custom inline addon padding
        $expected = <<<HTML
        <div class="form-text-container ">
            <div class="inline-addon">
                <span>foo</span>
            </div>

            <input class="form-input form-text pl-20" name="search" id="search" type="text" />
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-input name="search" inline-addon="foo" inline-addon-padding="pl-20" />'
        );
    }

    /** @test */
    public function inline_addon_can_be_slotted(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-input name="search">
            <x-slot name="inlineAddon">foo</x-slot>
        </x-input>
        HTML;

        $padding = Input::DEFAULT_INLINE_ADDON_PADDING;

        $expected = <<<HTML
        <div class="form-text-container ">
            <div class="inline-addon">
                <span>foo</span>
            </div>

            <input class="form-input form-text {$padding}" name="search" id="search" type="text" />
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function can_have_leading_icon(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-input name="search">
            <x-slot name="leadingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $expected = <<<HTML
        <div class="form-text-container ">
            <div class="leading-icon">icon here</div>

            <input class="form-input form-text has-leading-icon" name="search" id="search" type="text" />
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function only_renders_one_type_of_leading_addon(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-input name="search" leading-addon="foo" inline-addon="bar">
            <x-slot name="leadingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $expected = <<<HTML
        <div class="form-text-container ">
            <span class="leading-addon">foo</span>

            <input class="form-input form-text has-leading-addon" name="search" id="search" type="text" />
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function can_have_trailing_addon(): void
    {
        $this->withViewErrors([]);

        $padding = Input::DEFAULT_TRAILING_ADDON_PADDING;

        $expected = <<<HTML
        <div class="form-text-container ">
            <input class="form-input form-text {$padding}" name="search" id="search" type="text" />

            <div class="trailing-addon">
                <span>foo</span>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-input name="search" trailing-addon="foo" />'
        );

        // With custom trailing addon padding
        $expected = <<<HTML
        <div class="form-text-container ">
            <input class="form-input form-text pr-20" name="search" id="search" type="text" />

            <div class="trailing-addon">
                <span>foo</span>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-input name="search" trailing-addon="foo" trailing-addon-padding="pr-20" />'
        );
    }

    /** @test */
    public function trailing_addon_can_be_slotted(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-input name="search" trailing-addon-padding="pr-20">
            <x-slot name="trailingAddon">
                foo slotted
            </x-slot>
        </x-input>
        HTML;

        $expected = <<<HTML
        <div class="form-text-container ">
            <input class="form-input form-text pr-20" name="search" id="search" type="text" />

            <div class="trailing-addon">
                <span>foo slotted</span>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function can_have_trailing_icon(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-input name="search">
            <x-slot name="trailingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $expected = <<<HTML
        <div class="form-text-container ">
            <input class="form-input form-text has-trailing-icon" name="search" id="search" type="text" />

            <div class="trailing-icon">icon here</div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function will_only_render_one_type_of_trailing_addon(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-input name="search" trailing-addon="foo">
            <x-slot name="trailingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $expected = <<<HTML
        <div class="form-text-container ">
            <input class="form-input form-text pr-12" name="search" id="search" type="text" />

            <div class="trailing-addon">
                <span>foo</span>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function can_have_both_leading_and_trailing_addons(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-input name="search" leading-addon="foo">
            <x-slot name="trailingIcon">icon here</x-slot>
        </x-input>
        HTML;

        $expected = <<<HTML
        <div class="form-text-container ">
            <span class="leading-addon">foo</span>

            <input class="form-input form-text has-leading-addon has-trailing-icon" name="search" id="search" type="text" />

            <div class="trailing-icon">icon here</div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function it_adds_aria_attributes_when_there_is_an_error(): void
    {
        $this->withViewErrors(['search' => 'required']);

        $expected = <<<HTML
        <div class="form-text-container ">
            <input class="form-input form-text input-error" name="search" id="inputSearch" type="text" aria-invalid="true" aria-describedby="inputSearch-error" />
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-input name="search" id="inputSearch" />'
        );
    }

    /** @test */
    public function it_combines_aria_describedby_on_error_if_the_attribute_is_present(): void
    {
        $this->withViewErrors(['search' => 'required']);

        $expected = <<<HTML
        <div class="form-text-container ">
            <input class="form-input form-text input-error" aria-describedby="search-help search-error" name="search" id="search" type="text" aria-invalid="true" />
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-input name="search" aria-describedby="search-help" />'
        );
    }

    /** @test */
    public function can_have_a_max_width_set_on_the_container(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-input max-width="sm" name="name" />
        HTML;

        $expected = <<<HTML
        <div class="form-text-container max-w-sm">
            <input class="form-input form-text" name="name" id="name" type="text" />
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }
}
