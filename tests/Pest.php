<?php

use Rawilk\FormComponents\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

// Helpers

function flashOld(array $input): void
{
    session()->flashInput($input);
}
