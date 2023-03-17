<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

class EmailTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->withViewErrors([]);

        $expected = <<<'HTML'
        <div class="form-text-container ">
            <input class="form-input form-text" name="email" id="email" type="email" />
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-email name="email" />'
        );
    }

    /** @test */
    public function email_type_will_not_be_overridden(): void
    {
        $this->withViewErrors([]);

        $expected = <<<'HTML'
        <div class="form-text-container ">
            <input class="form-input form-text custom-class" name="foo" id="bar" type="email" />
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-email name="foo" id="bar" class="custom-class" type="url" />'
        );
    }
}
