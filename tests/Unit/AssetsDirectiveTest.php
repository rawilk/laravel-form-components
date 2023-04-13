<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Rawilk\FormComponents\Facades\FormComponents;

it('outputs the script source', function () {
    $this->assertStringContainsString(
        '<script src="/form-components/form-components.js?',
        FormComponents::javaScript(),
    );
});

it('outputs a comment when app is in debug mode', function () {
    config()->set('app.debug', true);

    $this->assertStringContainsString(
        '<!-- FormComponents Scripts -->',
        FormComponents::javaScript(),
    );
});

it('does not output a comment when not in debug mode', function () {
    config()->set('app.debug', false);

    $this->assertStringNotContainsString(
        '<!-- FormComponents Scripts -->',
        FormComponents::javaScript(),
    );
});

it('can use a custom asset url', function () {
    config()->set('form-components.asset_url', 'https://example.com');

    $this->assertStringContainsString(
        '<script src="https://example.com/form-components/form-components.js?',
        FormComponents::javaScript(),
    );
});

it('accepts an asset url as an argument', function () {
    $this->assertStringContainsString(
        '<script src="https://example.com/form-components/form-components.js?',
        FormComponents::javaScript(['asset_url' => 'https://example.com']),
    );
});

it('can output a nonce on the script tag', function () {
    $nonce = Str::random(32);

    $this->assertStringContainsString(
        "nonce=\"{$nonce}\"",
        FormComponents::javaScript(['nonce' => $nonce]),
    );
});
