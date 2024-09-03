const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.scripts([
    'node_modules/bs-custom-file-input/dist/bs-custom-file-input.min.js',
], 'public/js/vendor.js').sourceMaps();

mix.js('resources/js/app.js', 'public/js').sourceMaps();
mix.js('resources/js/adminlte.min.js', 'public/js').sourceMaps();

mix.sass('resources/sass/app.scss', 'public/css');
mix.css('resources/sass/adminlte.min.css', 'public/css');

mix.copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');
mix.copyDirectory('resources/assets/fonts', 'public/fonts');
mix.copyDirectory('vendor/tinymce/tinymce', 'public/js/tinymce');
