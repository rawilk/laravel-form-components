<?php

declare(strict_types=1);

namespace Rawilk\FormComponents;

final class FormComponents
{
    private static array $styles = [];
    private static array $scripts = [];

    public static function addStyle(string $style): void
    {
        if (! in_array($style, static::$styles, true)) {
            static::$styles[] = $style;
        }
    }

    public static function styles(): array
    {
        return static::$styles;
    }

    public static function outputStyles(bool $force = false): string
    {
        if (! $force && static::scriptsAreDisabled()) {
            return '';
        }

        return collect(static::$styles)->map(function (string $style) {
            return '<link rel="stylesheet" href="' . $style . '" />';
        })->implode(PHP_EOL);
    }

    public static function addScript(string $script): void
    {
        if (! in_array($script, static::$scripts, true)) {
            static::$scripts[] = $script;
        }
    }

    public static function scripts(): array
    {
        return static::$scripts;
    }

    public static function outputScripts(bool $force = false): string
    {
        if (! $force && static::scriptsAreDisabled()) {
            return '';
        }

        return collect(static::$scripts)->map(function (string $script) {
            return '<script src="' . $script . '"></script>';
        })->implode(PHP_EOL);
    }

    private static function scriptsAreDisabled(): bool
    {
        return ! config('app.debug');
    }
}
