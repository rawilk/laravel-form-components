<?php

declare(strict_types=1);

namespace Rawilk\FormComponents;

final class FormComponents
{
    private array $styles = [];
    private array $scripts = [];

    public function addStyle(string $style): void
    {
        if (! in_array($style, $this->styles, true)) {
            $this->styles[] = $style;
        }
    }

    public function styles(): array
    {
        return $this->styles;
    }

    public function outputStyles(bool $force = false): string
    {
        if (! $force && $this->scriptsAreDisabled()) {
            return '';
        }

        return collect($this->styles)->map(function (string $style) {
            return '<link rel="stylesheet" href="' . $style . '" />';
        })->implode(PHP_EOL);
    }

    public function addScript(string $script): void
    {
        if (! in_array($script, $this->scripts, true)) {
            $this->scripts[] = $script;
        }
    }

    public function scripts(): array
    {
        return $this->scripts;
    }

    public function outputScripts(bool $force = false, $options = []): string
    {
        $js = $this->javaScript($options);

        if (! $force && $this->scriptsAreDisabled()) {
            return $js;
        }

        return $js . collect($this->scripts)->map(function (string $script) {
            return '<script src="' . $script . '"></script>';
        })->implode(PHP_EOL);
    }

    /**
     * This will output the JavaScript necessary to run some components
     * such as CustomSelect.
     *
     * @param array $options
     * @return string
     */
    public function javaScript(array $options = []): string
    {
        $html = config('app.debug') ? ['<!-- FormComponents Scripts -->'] : [];

        $html[] = $this->javaScriptAssets($options);

        return implode(PHP_EOL, $html);
    }

    private function scriptsAreDisabled(): bool
    {
        if (config('form-components.link_vendor_cdn_assets') === false) {
            return true;
        }

        return ! config('app.debug');
    }

    private function javaScriptAssets(array $options = []): string
    {
        $appUrl = config('form-components.asset_url', rtrim($options['asset_url'] ?? '', '/'));

        $manifest = json_decode(file_get_contents(__DIR__ . '/../dist/mix-manifest.json'), true);
        $versionedFileName = $manifest['/form-components.js'];

        $fullAssetPath = "{$appUrl}/form-components{$versionedFileName}";

        return <<<HTML
        <script src="{$fullAssetPath}" data-turbolinks-eval="false"></script>
        HTML;
    }
}
