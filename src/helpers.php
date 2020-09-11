<?php

if (! function_exists('formComponentName')) {
    /**
     * Return a prefixed version of a form-components component name
     * if a prefix is defined in config.
     *
     * @param string $component
     * @return string
     */
    function formComponentName(string $component): string
    {
        $prefix = config('form-components.prefix');

        return $prefix
            ? "{$prefix}-{$component}"
            : $component;
    }
}
