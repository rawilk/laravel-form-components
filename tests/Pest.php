<?php

use Rawilk\FormComponents\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

uses()
    ->beforeEach(function () {
        config()->set('form-components.defaults.global.show_errors', true);
    })
    ->in(__DIR__ . '/Components');

// Helpers

function flashOld(array $input): void
{
    session()->flashInput($input);
}
