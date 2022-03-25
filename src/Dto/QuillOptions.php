<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Dto;

class QuillOptions
{
    public string $theme = 'snow';
    public null|array $toolbar = null;

    // Toolbar options
    public bool|array $font = true;
    public bool $size = true;
    public bool $bold = true;
    public bool $italic = true;
    public bool $underline = true;
    public bool $strike = true;
    public bool|array $color = true;
    public bool|array $background = true;
    public bool $scripts = true;
    public bool $codeBlock = true;
    public bool $blockQuote = true;
    public bool $orderedList = true;
    public bool $unOrderedList = true;
    public bool $indentText = true;
    public bool $link = true;
    public bool $image = false;
    public bool $clearFormatting = true;
    public bool $alignments = true;
    public array $customToolbarButtons = [];
    public array $toolbarHandlers = [];

    public static function defaults(): self
    {
        return new static;
    }

    public function theme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function toolbar(array $toolbar): self
    {
        $this->toolbar = $toolbar;

        return $this;
    }

    public function usingFonts(bool|array $fonts): self
    {
        $this->font = $fonts;

        return $this;
    }

    public function hideSize(): self
    {
        $this->size = false;

        return $this;
    }

    public function hideBold(): self
    {
        $this->bold = false;

        return $this;
    }

    public function hideItalic(): self
    {
        $this->italic = false;

        return $this;
    }

    public function hideUnderline(): self
    {
        $this->underline = false;

        return $this;
    }

    public function hideStrike(): self
    {
        $this->strike = false;

        return $this;
    }

    public function hideFontStyles(): self
    {
        $this->bold = false;
        $this->italic = false;
        $this->underline = false;
        $this->strike = false;

        return $this;
    }

    public function hideColor(): self
    {
        $this->color = false;

        return $this;
    }

    public function usingColors(array $colors): self
    {
        $this->color = $colors;

        return $this;
    }

    public function hideBackground(): self
    {
        $this->background = false;

        return $this;
    }

    public function usingBackground(array $colors): self
    {
        $this->background = $colors;

        return $this;
    }

    public function hideScripts(): self
    {
        $this->scripts = false;

        return $this;
    }

    public function hideCodeBlock(): self
    {
        $this->codeBlock = false;

        return $this;
    }

    public function hideBlockQuote(): self
    {
        $this->blockQuote = false;

        return $this;
    }

    public function hideOrderedList(): self
    {
        $this->orderedList = false;

        return $this;
    }

    public function hideUnOrderedList(): self
    {
        $this->unOrderedList = false;

        return $this;
    }

    public function hideIndentText(): self
    {
        $this->indentText = false;

        return $this;
    }

    public function hideLists(): self
    {
        $this->orderedList = false;
        $this->unOrderedList = false;
        $this->indentText = false;

        return $this;
    }

    public function hideLink(): self
    {
        $this->link = false;

        return $this;
    }

    public function hideAlignments(): self
    {
        $this->alignments = false;

        return $this;
    }

    public function showImage(): self
    {
        $this->image = true;

        return $this;
    }

    public function hideClearFormatting(): self
    {
        $this->clearFormatting = false;

        return $this;
    }

    public function withToolbarButton(string $key, $handler, $options = null): self
    {
        $this->toolbarHandlers[$key] = $handler;

        $button = is_array($options) ? [$key => $options] : $key;
        $this->customToolbarButtons[] = $button;

        return $this;
    }

    public function getToolbar(): array
    {
        if (is_array($this->toolbar)) {
            return $this->toolbar;
        }

        return array_values(array_filter([
            $this->fontToolbar(),
            $this->fontStyleToolbar(),
            $this->colorToolbar(),
            $this->scripts ? [['script' => 'super'], ['script' => 'sub']] : null,
            $this->quoteToolbar(),
            $this->listToolbar(),
            $this->alignments ? [['align' => ['', 'center', 'right', 'justify']]] : null,
            $this->linkToolbar(),
            $this->clearFormatting ? ['clean'] : null,
            $this->customToolbarButtons,
        ]));
    }

    private function fontToolbar(): array
    {
        $toolbar = [];

        if ($this->font === true || is_array($this->font)) {
            $toolbar[] = ['font' => is_array($this->font) ? $this->font : []];
        }

        if ($this->size) {
            $toolbar[] = ['size' => []];
        }

        return $toolbar;
    }

    private function fontStyleToolbar(): array
    {
        return array_keys(array_filter([
            'bold' => $this->bold,
            'italic' => $this->italic,
            'underline' => $this->underline,
            'strike' => $this->strike,
        ]));
    }

    private function colorToolbar(): array
    {
        $toolbar = [];

        if ($this->color === true || is_array($this->color)) {
            $toolbar[] = ['color' => is_array($this->color) ? $this->color : []];
        }

        if ($this->background === true || is_array($this->background)) {
            $toolbar[] = ['background' => is_array($this->background) ? $this->background : []];
        }

        return $toolbar;
    }

    private function quoteToolbar(): array
    {
        $toolbar = [];

        if ($this->codeBlock) {
            $toolbar[] = 'code-block';
        }

        if ($this->blockQuote) {
            $toolbar[] = 'blockquote';
        }

        return $toolbar;
    }

    private function listToolbar(): array
    {
        $toolbar = [];

        if ($this->orderedList) {
            $toolbar[] = ['list' => 'ordered'];
        }

        if ($this->unOrderedList) {
            $toolbar[] = ['list' => 'bullet'];
        }

        if ($this->indentText) {
            $toolbar[] = ['indent' => '-1'];
            $toolbar[] = ['indent' => '+1'];
        }

        return $toolbar;
    }

    private function linkToolbar(): array
    {
        $toolbar = [];

        if ($this->link) {
            $toolbar[] = 'link';
        }

        if ($this->image) {
            $toolbar[] = 'image';
        }

        return $toolbar;
    }
}
