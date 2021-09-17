const mix = require('laravel-mix');

mix.setPublicPath('dist');

mix.js('resources/js/index.js', 'form-components.js')
    .sourceMaps(false)
    .version()
    .disableSuccessNotifications();
