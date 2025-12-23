const mix = require('laravel-mix');

mix.options({ processCssUrls: false })
    .sass('resources/sass/admin/app.scss', 'public/backend_resources/css', { implementation: require('node-sass') });

mix.js('resources/js/admin/app.js', 'public/backend_resources/js');
mix.js('resources/js/admin/form.js', 'public/backend_resources/js');
mix.js('resources/js/admin/form-browse.js', 'public/backend_resources/js');
mix.js('resources/js/admin/form-with-editor.js', 'public/backend_resources/js');
mix.copy('node_modules/font-awesome/fonts/*', 'public/fonts');
mix.version();
mix.sourceMaps();

if (mix.inProduction()) {
    mix.version();
}
// mix.disableNotifications();
