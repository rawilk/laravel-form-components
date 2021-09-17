<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Files;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;

final class FilePondTest extends ComponentTestCase
{
    /** @test */
    public function can_be_rendered(): void
    {
        $this->blade('<x-file-pond />')
            ->assertSee('FilePond')
            ->assertSee('<input', false);
    }
}
