<?php

declare(strict_types=1);

namespace Rawilk\FormComponents;

final class FormComponents
{
    /**
     * This will output the JavaScript necessary to run some components
     * such as CustomSelect.
     */
    public function javaScript(array $options = []): string
    {
        $html = config('app.debug') ? ['<!-- FormComponents Scripts -->'] : [];

        $html[] = $this->javaScriptAssets($options);

        return implode(PHP_EOL, $html);
    }

    private function javaScriptAssets(array $options = []): string
    {
        $assetsUrl = config('form-components.asset_url') ?: rtrim($options['asset_url'] ?? '', '/');

        $manifest = json_decode(file_get_contents(__DIR__ . '/../dist/mix-manifest.json'), true);
        $versionedFileName = $manifest['/form-components.js'];

        $fullAssetPath = "{$assetsUrl}/form-components{$versionedFileName}";

        return <<<HTML
        <script src="{$fullAssetPath}" data-turbo-eval="false" data-turbolinks-eval="false"></script>
        HTML;
    }
}
