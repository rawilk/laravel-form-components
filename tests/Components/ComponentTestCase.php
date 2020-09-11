<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components;

use Gajus\Dindent\Indenter;
use Orchestra\Testbench\TestCase;
use Rawilk\FormComponents\FormComponentsServiceProvider;
use Rawilk\FormComponents\Tests\Concerns\InteractsWithViews;

abstract class ComponentTestCase extends TestCase
{
    use InteractsWithViews;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('view:clear');
    }

    protected function flashOld(array $input): void
    {
        session()->flashInput($input);

        request()->setLaravelSession(session());
    }

    protected function getPackageProviders($app): array
    {
        return [FormComponentsServiceProvider::class];
    }

    public function assertComponentRenders(string $expected, string $template, array $data = []): void
    {
        $indenter = new Indenter;

        $blade = (string) $this->blade($template, $data);
        $indented = $indenter->indent($blade);
        $cleaned = str_replace(
            [' >', "\n/>", ' </div>', '> ', "\n>"],
            ['>', ' />', "\n</div>", ">\n    ", ">"],
            $indented
        );
        $cleaned = $this->trimExcessWhitespace($cleaned);
        $expected = $this->trimExcessWhitespace($expected);

        self::assertSame($expected, $cleaned);
    }

    protected function trimExcessWhitespace(string $content): string
    {
        return trim(
            preg_replace('/\s+/', ' ', $content)
        );
    }
}
