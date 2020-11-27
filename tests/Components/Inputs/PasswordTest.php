<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

class PasswordTest extends ComponentTestCase
{
    /** @var string */
    protected const DEFAULT_CONTAINER_CLASS = 'form-text-container focus-within:ring-4 focus-within:ring-opacity-50 focus-within:ring-primary-400 focus-within:border-primary-300 rounded-md';

    protected function getPackageProviders($app): array
    {
        return array_merge(parent::getPackageProviders($app), [
            BladeHeroiconsServiceProvider::class,
        ]);
    }

    /** @test */
    public function can_render_component(): void
    {
        $this->withViewErrors([]);

        $showIcon = svg(config('form-components.components.password.show_password_icon'))->toHtml();
        $hideIcon = svg(config('form-components.components.password.hide_password_icon'))->toHtml();
        $containerClass = self::DEFAULT_CONTAINER_CLASS;

        $expected = <<<HTML
        <div x-data="{ show: false }"
             class="{$containerClass}">
            <input class="form-input form-text password-toggleable has-trailing-icon" name="password" id="password" :type="show ? 'text' : 'password'" />

            <div x-on:click="show = ! show"
                 :title="show ? 'Hide' : 'Show'"
                 class="trailing-icon password-toggle clickable"
                 x-cloak>
                <span x-show="! show">
                    {$showIcon}
                </span>

                <span x-show="show">
                    {$hideIcon}
                </span>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-password name="password" />'
        );
    }

    /** @test */
    public function show_toggle_password_can_be_disabled(): void
    {
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="form-text-container">
            <input class="form-input form-text" name="password" id="password" type="password" />
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-password name="password" :show-toggle="false" />'
        );
    }

    /** @test */
    public function can_have_leading_addon(): void
    {
        $this->withViewErrors([]);

        $showIcon = svg(config('form-components.components.password.show_password_icon'))->toHtml();
        $hideIcon = svg(config('form-components.components.password.hide_password_icon'))->toHtml();
        $containerClass = self::DEFAULT_CONTAINER_CLASS;

        $expected = <<<HTML
        <div x-data="{ show: false }"
             class="{$containerClass}">
             <span class="leading-addon">foo</span>

            <input class="form-input form-text has-leading-addon password-toggleable has-trailing-icon" name="password" id="password" :type="show ? 'text' : 'password'" />

            <div x-on:click="show = ! show"
                 :title="show ? 'Hide' : 'Show'"
                 class="trailing-icon password-toggle clickable"
                 x-cloak>
                <span x-show="! show">
                    {$showIcon}
                </span>

                <span x-show="show">
                    {$hideIcon}
                </span>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-password name="password" leading-addon="foo" />'
        );
    }

    /** @test */
    public function it_ignores_trailing_addons(): void
    {
        $this->withViewErrors([]);

        $template = <<<HTML
        <x-password name="password" :show-toggle="false" trailing-addon="foo" />
        HTML;

        // The "trailing-addon" should be regarded as a custom attribute instead
        $expected = <<<HTML
        <div class="form-text-container">
            <input class="form-input form-text" trailing-addon="foo" name="password" id="password" type="password" />
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function slotted_trailing_addons_are_ignored(): void
    {
        $this->withViewErrors([]);

        // Even if we try to specify a trailing addon, the component should render its toggle trailing addon instead.
        $template = <<<HTML
        <x-password name="password" leading-addon="foo">
            <x-slot name="trailingAddon">foo</x-slot>
        </x-password>
        HTML;

        $showIcon = svg(config('form-components.components.password.show_password_icon'))->toHtml();
        $hideIcon = svg(config('form-components.components.password.hide_password_icon'))->toHtml();
        $containerClass = self::DEFAULT_CONTAINER_CLASS;

        $expected = <<<HTML
        <div x-data="{ show: false }"
             class="{$containerClass}">
             <span class="leading-addon">foo</span>

            <input class="form-input form-text has-leading-addon password-toggleable has-trailing-icon" name="password" id="password" :type="show ? 'text' : 'password'" />

            <div x-on:click="show = ! show"
                 :title="show ? 'Hide' : 'Show'"
                 class="trailing-icon password-toggle clickable"
                 x-cloak>
                <span x-show="! show">
                    {$showIcon}
                </span>

                <span x-show="show">
                    {$hideIcon}
                </span>
            </div>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }
}
