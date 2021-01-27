---
title: PhpStorm Interaction
sort: 2
---

## Extending PhpStorm

You may wish to extend PhpStorm to extend the blade directives of this package:

1. In PhpStorm, open Preferences, and navigate to **Languages and Frameworks -> PHP -> Blade** (File | Settings | Languages & Frameworks | PHP | Blade)
2. Uncheck "Use default settings", then click on the **Directives** tab.
3. Add the following new directives for the laravel-form-components package:

### @fcStyles

- has parameter = YES
- Prefix: `<?php echo \\Rawilk\\FormComponents\\Facades\\FormComponents::outputStyles(`
- Suffix: `); ?>`

### @fcScripts

- has parameter = YES
- Prefix: `<?php echo \\Rawilk\\FormComponents\\Facades\\FormComponents::outputScripts(`
- Suffix: `); ?>`

### @fcJavaScript

- has parameter = YES
- Prefix: `<?php echo \\Rawilk\\FormComponents\\Facades\\FormComponents::javaScript(`
- Suffix: `); ?>`
