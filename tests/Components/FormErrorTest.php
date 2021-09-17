<?php

namespace Rawilk\FormComponents\Tests\Components;

final class FormErrorTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->withViewErrors(['first_name' => 'Name is required.']);

        $this->blade('<x-form-error name="first_name" />')
            ->assertSeeText('Name is required.')
            ->assertSee('form-error')
            ->assertSee('first_name-error');
    }

    /** @test */
    public function it_can_be_slotted(): void
    {
        $this->withViewErrors(['first_name' => ['Incorrect first name.', 'Needs at least 5 characters.']]);

        $template = <<<HTML
        <x-form-error name="first_name" tag="div">
            <ul>
                @foreach (\$component->messages(\$errors) as \$error)
                    <li>{{ \$error }}</li>
                @endforeach
            </ul>
        </x-form-error>
        HTML;

        $this->blade($template)
            ->assertSeeInOrder([
                '<li>Incorrect first name.</li>',
                '<li>Needs at least 5 characters.</li>',
            ], false);
    }
}
