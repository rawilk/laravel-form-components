<?php

declare(strict_types=1);

use Rawilk\FormComponents\Support\FormComponentsTagCompiler;

beforeEach(function () {
    $this->compiler = new FormComponentsTagCompiler();
});

it('compiles the scripts tag', function (string $tag) {
    $result = $this->compiler->compile($tag);

    expect('@fcScripts')->toBe($result);
})->with([
    '<fc:scripts />',
    '<fc:javaScript />',
]);
