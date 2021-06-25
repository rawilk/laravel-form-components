<?php

namespace Rawilk\FormComponents\Tests\Components;

use Spatie\Snapshots\MatchesSnapshots;

class FormTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_be_rendered(): void
    {
        $view = $this->blade(
            <<<HTML
            <x-form action="http://example.com">
                Form fields...
            </x-form>
            HTML
        );

        $this->assertMatchesSnapshot((string) $view);
    }

    /** @test */
    public function the_method_can_be_set(): void
    {
        $template = <<<HTML
        <x-form method="PUT" action="http://example.com">
            Form fields...
        </x-form>
        HTML;

        $this->assertMatchesSnapshot(
            (string) $this->blade($template)
        );
    }

    /** @test */
    public function it_can_enable_file_uploads(): void
    {
        $template = <<<HTML
        <x-form method="PUT" action="http://example.com" has-files>
            Form fields...
        </x-form>
        HTML;

        $this->assertMatchesSnapshot(
            (string) $this->blade($template)
        );
    }

    /** @test */
    public function spellcheck_can_be_enabled(): void
    {
        $template = <<<HTML
        <x-form action="http://example.com" spellcheck>
            Form fields...
        </x-form>
        HTML;

        $this->assertMatchesSnapshot(
            (string) $this->blade($template)
        );
    }

    /** @test */
    public function action_is_optional(): void
    {
        $template = <<<HTML
        <x-form>
            Form fields...
        </x-form>
        HTML;

        $this->assertMatchesSnapshot(
            (string) $this->blade($template)
        );
    }

    /**
     * @test
     * @dataProvider formMethodsWithoutCsrf
     * @param string $method
     */
    public function csrf_input_is_not_rendered_on_certain_form_methods(string $method): void
    {
        $view = $this->blade(
            '<x-form :method="$method">Form fields...</x-form>',
            ['method' => $method],
        );

        $this->assertMatchesSnapshot((string) $view);
    }

    /** @test */
    public function custom_attributes_can_be_applied(): void
    {
        $template = <<<HTML
        <x-form action="http://example.test" method="GET" wire:submit.prevent="submit">
            Form fields...
        </x-form>
        HTML;

        $this->assertMatchesSnapshot(
            (string) $this->blade($template)
        );
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
