<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

class PasswordTest extends ComponentTestCase
{
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

        $expected = <<<HTML
        <div x-data="{ show: false }"
             class="form-text-container ">
            <input class="form-input form-text has-trailing-icon" name="password" id="password" :type="show ? 'text' : 'password'" />

            <div @click="show = ! show"
                 :title="show ? 'Hide' : 'Show'"
                 class="trailing-icon clickable">
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
        <div class="form-text-container ">
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

        $expected = <<<HTML
        <div x-data="{ show: false }"
             class="form-text-container ">
             <span class="leading-addon">foo</span>

            <input class="form-input form-text has-leading-addon has-trailing-icon" name="password" id="password" :type="show ? 'text' : 'password'" />

            <div @click="show = ! show"
                 :title="show ? 'Hide' : 'Show'"
                 class="trailing-icon clickable">
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
        <div class="form-text-container ">
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

        $expected = <<<HTML
        <div x-data="{ show: false }"
             class="form-text-container ">
             <span class="leading-addon">foo</span>

            <input class="form-input form-text has-leading-addon has-trailing-icon" name="password" id="password" :type="show ? 'text' : 'password'" />

            <div @click="show = ! show"
                 :title="show ? 'Hide' : 'Show'"
                 class="trailing-icon clickable">
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
