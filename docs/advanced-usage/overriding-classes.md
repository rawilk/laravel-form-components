---
title: Overriding Classes
sort: 3
---

## Overriding Classes

When you override a component class with your own, you will need to update the class referenced for the component alias in the config.
For the `select` component, it would look like this:

**Custom Class:**

```php
<?php

namespace App\View;

use Rawilk\FormComponents\Components\Inputs\Select;

class MySelect extends Select
{
    // Override stuff here...

    /*
     * You will need to override this method to
     * let the BladeComponent parent class
     * know where to look for this component's
     * view.
     *
     * Alternatively, you can override the
     * "render" method.
     */
    public static function getName(): string
    {
        return 'inputs.select';
    }
}
```

**Config:**

```php
<?php

return [
    'components' => [
        // ...
        'select' => \App\View\MySelect::class,
    ],

    // ...
];
```

> {note} If you choose to override a class, you will need to override either the `getName` method (as shown in code above)
> or override the `render` method, so the parent `BladeComponent` class will use the correct view.

Some component classes will also need to be bound in the container in a service provider since internally this package does not
reference components by alias. One of those components is the `label` component, which is referenced by the `form-group` component
internally. To have the correct class be used, you can bind the overridden class in a service provider in the `register` method:

```php
<?php

namespace App\Providers;

use App\View\MyCustomLabelClass;
use Illuminate\Support\ServiceProvider;
use Rawilk\FormComponents\Components\Label;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Label::class, MyCustomLabelClass::class);
    }
}
```

Any component classes you override should follow the same pattern as illustrated above in a service provider.
