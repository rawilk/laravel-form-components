<?php

declare(strict_types=1);

namespace Rawilk\FormComponents\Tests;

use Illuminate\Testing\Assert as PHPUnit;
use Illuminate\Testing\Constraints\SeeInOrder;
use Illuminate\View\View;

class TestView
{
    /*
     * The original view.
     */
    protected View $view;

    /*
     * The rendered view contents.
     */
    protected string $rendered;

    public function __construct(View $view)
    {
        $this->view = $view;
        $this->rendered = $view->render();
    }

    /**
     * Assert that the given string is contained within the view.
     *
     * @return $this
     */
    public function assertSee(string $value, bool $escaped = true): self
    {
        $value = $escaped ? e($value) : $value;

        PHPUnit::assertStringContainsString($value, $this->rendered);

        return $this;
    }

    /**
     * Assert that the given strings are contained in order within the view.
     *
     * @return $this
     */
    public function assertSeeInOrder(array $values, bool $escape = true): self
    {
        $values = $escape ? array_map('e', ($values)) : $values;

        PHPUnit::assertThat($values, new SeeInOrder($this->rendered));

        return $this;
    }

    /**
     * Assert that the given string is contained within the view text.
     *
     * @return $this
     */
    public function assertSeeText(string $value, bool $escape = true): self
    {
        $value = $escape ? e($value) : $value;

        PHPUnit::assertStringContainsString($value, strip_tags($this->rendered));

        return $this;
    }

    /**
     * Assert that the given strings are contained in order within the view text.
     *
     * @return $this
     */
    public function assertSeeTextInOrder(array $values, bool $escape = true): self
    {
        $values = $escape ? array_map('e', ($values)) : $values;

        PHPUnit::assertThat($values, new SeeInOrder(strip_tags($this->rendered)));

        return $this;
    }

    /**
     * Assert that the given string is not contained within the view.
     *
     * @return $this
     */
    public function assertDontSee(string $value, bool $escape = true): self
    {
        $value = $escape ? e($value) : $value;

        PHPUnit::assertStringNotContainsString($value, $this->rendered);

        return $this;
    }

    /**
     * Assert that the given string is not contained within the view text.
     *
     * @return $this
     */
    public function assertDontSeeText(string $value, bool $escape = true): self
    {
        $value = escape ? e($value) : $value;

        PHPUnit::assertStringNotContainsString($value, strip_tags($this->rendered));

        return $this;
    }

    public function __toString(): string
    {
        return $this->rendered;
    }
}
