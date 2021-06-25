<?php

namespace Rawilk\FormComponents\Tests\Components\Inputs;

use Rawilk\FormComponents\Tests\Components\ComponentTestCase;
use Spatie\Snapshots\MatchesSnapshots;

class TextareaTest extends ComponentTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function can_be_rendered(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-textarea name="about" />')
        );
    }

    /** @test */
    public function specific_attributes_can_be_used(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-textarea name="about" id="aboutMe" rows="5" cols="8" class="p-4">About me text</x-textarea>')
        );
    }

    /** @test */
    public function can_display_old_value(): void
    {
        $this->flashOld(['about' => 'About me text']);

        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-textarea name="about" />')
        );
    }

    /** @test */
    public function name_can_be_omitted(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-textarea />')
        );
    }

    /** @test */
    public function accepts_a_container_class(): void
    {
        $this->assertMatchesSnapshot(
            (string) $this->blade('<x-textarea container-class="foo" />')
        );
    }
}
