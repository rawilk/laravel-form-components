<?php

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class TextareaTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->blade('<x-textarea name="about" />')
            ->assertSee('<textarea', false)
            ->assertSee('name="about"', false)
            ->assertSee('id="about"', false)
            ->assertSee('form-input');
    }

    /** @test */
    public function specific_attributes_can_be_used(): void
    {
        $this->blade('<x-textarea name="about" id="aboutMe" rows="5" cols="8" class="p-4">About me text</x-textarea>')
            ->assertSeeText('About me text')
            ->assertSee('id="aboutMe"', false)
            ->assertSee('p-4')
            ->assertSee('form-input')
            ->assertSee('rows="5"', false)
            ->assertSee('cols="8"', false);
    }

    /** @test */
    public function can_display_old_value(): void
    {
        $this->flashOld(['about' => 'About me text']);

        $this->blade('<x-textarea name="about" />')
            ->assertSeeText('About me text');
    }

    /** @test */
    public function name_can_be_omitted(): void
    {
        $this->blade('<x-textarea />')
            ->assertDontSee('name=')
            ->assertDontSee('id=');
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        $this->blade('<x-textarea container-class="foo" />')
            ->assertSee('foo');
    }
}
