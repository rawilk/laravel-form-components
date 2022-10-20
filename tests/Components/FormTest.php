<?php

namespace Rawilk\FormComponents\Tests\Components;

final class FormTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $template = <<<'HTML'
        <x-form action="http://example.com">
            Form fields...
        </x-form>
        HTML;

        $this->blade($template)
            ->assertSee('<form', false)
            ->assertSee('action="http://example.com"', false)
            ->assertSee('method=')
            ->assertSee('_token')
            ->assertSeeText('Form fields...');
    }

    /** @test */
    public function the_method_can_be_set(): void
    {
        $template = <<<'HTML'
        <x-form method="put" action="http://example.com">
            Form fields...
        </x-form>
        HTML;

        $this->blade($template)
            ->assertSee('method="POST"', false)
            ->assertSee('name="_method"', false)
            ->assertSee('value="PUT"', false);
    }

    /** @test */
    public function it_can_enable_file_uploads(): void
    {
        $template = <<<'HTML'
        <x-form method="POST" action="http://example.com" has-files>
            Form fields...
        </x-form>
        HTML;

        $this->blade($template)
            ->assertSee('enctype="multipart/form-data"', false);
    }

    /** @test */
    public function spellcheck_can_be_enabled(): void
    {
        $template = <<<'HTML'
        <x-form action="http://example.com" spellcheck>
            Form fields...
        </x-form>
        HTML;

        $this->blade($template)
            ->assertDontSee('spellcheck');
    }

    /** @test */
    public function action_is_optional(): void
    {
        $this->blade('<x-form />')
            ->assertDontSee('action=');
    }

    /**
     * @test
     * @dataProvider formMethodsWithoutCsrf
     *
     * @param  string  $method
     */
    public function csrf_input_is_not_rendered_on_certain_form_methods(string $method): void
    {
        $template = <<<HTML
        <x-form method="$method">
            Form fields...
        </x-form>
        HTML;

        $this->blade($template)
            ->assertDontSee('_token');
    }

    /** @test */
    public function custom_attributes_can_be_applied(): void
    {
        $template = <<<'HTML'
        <x-form action="http://example.test" method="GET" wire:submit.prevent="submit">
            Form fields...
        </x-form>
        HTML;

        $this->blade($template)
            ->assertSee('wire:submit.prevent="submit"', false)
            ->assertSee('method="GET"', false);
    }

    public function formMethodsWithoutCsrf(): array
    {
        return [
            ['GET'],
            ['HEAD'],
            ['OPTIONS'],
        ];
    }
}
