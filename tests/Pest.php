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

function isOnPhp8_0(): bool
{
    // return true if on PHP 8.0 but less than 8.1.
    return PHP_VERSION_ID >= 80000 && PHP_VERSION_ID < 80100;
}
