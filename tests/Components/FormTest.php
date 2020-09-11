<?php

namespace Rawilk\FormComponents\Tests\Components;

class FormTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $template = <<<HTML
        <x-form action="http://example.com">
            Form fields...
        </x-form>
        HTML;

        $expected = <<<HTML
        <form method="POST" action="http://example.com" spellcheck="false">
            <input type="hidden" name="_token" value="">
            Form fields...

        </form>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function the_method_can_be_set(): void
    {
        $template = <<<HTML
        <x-form method="PUT" action="http://example.com">
            Form fields...
        </x-form>
        HTML;

        $expected = <<<HTML
        <form method="POST" action="http://example.com" spellcheck="false">
            <input type="hidden" name="_token" value="">
            <input type="hidden" name="_method" value="PUT">
            Form fields...

        </form>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function it_can_enable_file_uploads(): void
    {
        $template = <<<HTML
        <x-form method="PUT" action="http://example.com" has-files>
            Form fields...
        </x-form>
        HTML;

        $expected = <<<HTML
        <form method="POST" action="http://example.com" enctype="multipart/form-data" spellcheck="false">
            <input type="hidden" name="_token" value="">
            <input type="hidden" name="_method" value="PUT">
            Form fields...

        </form>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function spellcheck_can_be_enabled(): void
    {
        $template = <<<HTML
        <x-form action="http://example.com" spellcheck>
            Form fields...
        </x-form>
        HTML;

        $expected = <<<HTML
        <form method="POST" action="http://example.com">
            <input type="hidden" name="_token" value="">
            Form fields...

        </form>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function action_is_optional(): void
    {
        $template = <<<HTML
        <x-form>
            Form fields...
        </x-form>
        HTML;

        $expected = <<<HTML
        <form method="POST" spellcheck="false">
            <input type="hidden" name="_token" value="">
            Form fields...

        </form>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /**
     * @test
     * @dataProvider formMethodsWithoutCsrf
     * @param string $method
     */
    public function csrf_input_is_not_rendered_on_certain_form_methods(string $method): void
    {
        $template = <<<HTML
        <x-form method="{$method}">
            Form fields...
        </x-form>
        HTML;

        $expected = <<<HTML
        <form method="{$method}" spellcheck="false">
            Form fields...
        </form>
        HTML;

        $this->assertComponentRenders($expected, $template);
    }

    /** @test */
    public function custom_attributes_can_be_applied(): void
    {
        $template = <<<HTML
        <x-form action="http://example.test" method="GET" wire:submit.prevent="submit">
            Form fields...
        </x-form>
        HTML;

        $expected = <<<HTML
        <form method="GET" action="http://example.test" spellcheck="false" wire:submit.prevent="submit">
            Form fields...
        </form>
        HTML;

        $this->assertComponentRenders($expected, $template);
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
