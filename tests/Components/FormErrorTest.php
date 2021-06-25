<?php

namespace Rawilk\FormComponents\Tests\Components;

use Spatie\Snapshots\MatchesSnapshots;

class FormErrorTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_be_rendered(): void
    {
        $this->withViewErrors(['first_name' => 'Name is required.']);

        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-form-error name="first_name" />')
        );
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

        $this->assertMatchesSnapshot((string) $this->blade($template));
    }
}
