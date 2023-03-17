<?php

namespace Rawilk\FormComponents\Tests\Components;

class FormErrorTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->withViewErrors(['first_name' => 'Name is required.']);

        $expected = <<<'HTML'
        <p class="form-error" id="first_name-error">
            Name is required.
        </p>
        HTML;

        $this->assertComponentRenders(
            $expected,
            '<x-form-error name="first_name" />'
        );
    }

    /** @test */
    public function it_can_be_slotted(): void
    {
        $this->withViewErrors(['first_name' => ['Incorrect first name.', 'Needs at least 5 characters.']]);

        $template = <<<'HTML'
        <x-form-error name="first_name" tag="div">
            <ul>
                @foreach ($component->messages($errors) as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-form-error>
        HTML;

        $expected = <<<'HTML'
        <div class="form-error" id="first_name-error">
            <ul>
                <li>Incorrect first name.</li>
                <li>Needs at least 5 characters.</li>
            </ul>
        </div>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }
}
