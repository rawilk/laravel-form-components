<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;
use Spatie\Snapshots\MatchesSnapshots;

class EmailTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_be_rendered(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-email name="email" />')
        );
    }

    /** @test */
    public function email_type_will_not_be_overridden(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-email name="foo" id="bar" class="custom-class" type="url" />')
        );
    }
}
