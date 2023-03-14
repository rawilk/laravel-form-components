<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Support;

use Illuminate\View\Compilers\ComponentTagCompiler;

class FormComponentsTagCompiler extends ComponentTagCompiler
{
    public function compile($value)
    {
        return $this->compileFormComponentsSelfClosingTags($value);
    }

    protected function compileFormComponentsSelfClosingTags($value): array|string|null
    {
        $pattern = "/
            <
                \s*
                fc\:([\w\-\:\.]*)
                \s*
                (?<attributes>
                    (?:
                        \s+
                        [\w\-:.@]+
                        (
                            =
                            (?:
                                \\\"[^\\\"]*\\\"
                                |
                                \'[^\']*\'
                                |
                                [^\'\\\"=<>]+
                            )
                        )?
                    )*
                    \s*
                )
            \/?>
        /x";

        return preg_replace_callback($pattern, function (array $matches) {
            $component = $matches[1];

            if ($component === 'javaScript' || $component === 'scripts') {
                return '@fcScripts';
            }

            return '';
        }, $value);
    }
}
