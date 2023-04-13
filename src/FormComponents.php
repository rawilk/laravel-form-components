<?php

declare(strict_types=1);

namespace Rawilk\FormComponents;

use Illuminate\Support\Facades\Vite;

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
        $nonce = $this->getNonce($options);

        $manifest = json_decode(file_get_contents(__DIR__ . '/../dist/manifest.json'), true);
        $versionedFileName = $manifest['/form-components.js'];

        $fullAssetPath = "{$assetsUrl}/form-components{$versionedFileName}";

        return <<<HTML
        <script src="{$fullAssetPath}" data-turbo-eval="false" data-turbolinks-eval="false" {$nonce}></script>
        HTML;
    }

    private function getNonce(array $options): string
    {
        if (isset($options['nonce'])) {
            return "nonce=\"{$options['nonce']}\"";
        }

        // If there is a csp package installed, i.e. spatie/laravel-csp, we'll check for the existence of the helper function.
        if (function_exists('csp_nonce') && $nonce = csp_nonce()) {
            return "nonce=\"{$nonce}\"";
        }

        if (function_exists('cspNonce') && $nonce = cspNonce()) {
            return "nonce=\"{$nonce}\"";
        }

        // Lastly, we'll check for the existence of a csp nonce from Vite.
        if (class_exists(Vite::class) && $nonce = Vite::cspNonce()) {
            return "nonce=\"{$nonce}\"";
        }

        return '';
    }
}
