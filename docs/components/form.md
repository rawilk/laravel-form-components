---
title: Form
sort: 1
---

## Introduction

The `form` component helps you with removing the bulk work when setting up forms in Laravel. By default, it sets the HTTP method
and CSRF directives and allows for easier to use syntax than the default HTML form tag.

## Basic Usage

The most basic usage of the `form` component exists in encapsulating some form elements:

```html
<x-form action="http://example.com">
    Form fields...
</x-form>
```

This will output the following HTML:

```html
<form method="POST" action="http://example.com" spellcheck="false">
    <input type="hidden" name="_token" value="...">
    <input type="hidden" name="_method" value="POST">

    Form fields...
</form>
```

By default, a `POST` HTTP method will be set. Of course, you can customize this. You can also enable spellcheck (remove the `spellcheck="false"` attribute that is set by default) as well:

```html
<x-form method="PUT" action="http://example.com" spellcheck>
    Form fields...
</x-form>
```

This will output the following HTML:

```html
<form method="POST" action="http://example.com">
    <input type="hidden" name="_token" value="...">
    <input type="hidden" name="_method" value="PUT">
    
    Form fields...
</form>
```

As you can see, a `_method` input was added since HTML tags only support `POST` and `GET` requests. Laravel uses the `_method` key to determine which exact route action is called.

## File Uploads

To enable file uploads in a form you can make use of the `has-files` attribute:

```html
<x-form action="http://example.com" has-files>
    Form fields...
</x-form>
```

This will output the following HTML:

```html
<form method="POST" action="http://example.com" enctype="multipart/form-data" spellcheck="false">
    <input type="hidden" name="_token" value="...">
    
    Form fields...
</form>
```

Now `file` input fields will be able to be submitted with the form.
