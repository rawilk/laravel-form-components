---
title: Extra Attributes
sort: 5
---

## Introduction

There may be times when you are rendering an input component where you may have an unknown amount of attributes you need to pass to the component.
The most common use case I have for it is when I'm building up an array of attributes for a component, and some attributes are conditional on what I send
to the component.

The current blade syntax doesn't allow for using conditional logic like `@if` when you're rendering a blade component, so I've come up with a prop called `extraAttributes`
on most of the components offered by this package. This will allow you to pass an array of attributes to the element, and the element will then render them onto the
applicable element for you.

## Basic Usage

Here's an arbitrary example of how one could build up an array of attributes in a Livewire component, and then pass them to an input component.

```php
public function getInputAttributesProperty(): array
{
    return array_filter([
        '@click' => "console.log('hi')",
        'data-name' => $this->name,
        'data-foo' => $this->name === 'foo' ? 'true' : null,
    ]);
}
```

```html
<x-input :extra-attributes="$this->inputAttributes" />
```
