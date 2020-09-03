<?php

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

class TextareaTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="form-text-container">
            <textarea name="about" id="about" class="form-input form-text" rows="3"></textarea>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-textarea name="about" />'
        );
    }

    /** @test */
    public function specific_attributes_can_be_used(): void
    {
        $this->withViewErrors([]);

        $expected = <<<HTML
        <div class="form-text-container">
            <textarea name="about" id="aboutMe" class="form-input form-text p-4" rows="5" cols="8">About me text</textarea>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-textarea name="about" id="aboutMe" rows="5" cols="8" class="p-4">About me text</x-textarea>'
        );
    }

    /** @test */
    public function can_display_old_value(): void
    {
        $this->flashOld(['about' => 'About me text']);

        $expected = <<<HTML
        <div class="form-text-container">
            <textarea name="about" id="about" class="form-input form-text" rows="3">About me text</textarea>
        </div>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-textarea name="about" />'
        );
    }
}
