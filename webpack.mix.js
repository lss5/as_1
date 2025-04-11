const mix = require('laravel-mix');

mix.sourceMaps().js('resources/js/app.js', 'public/js').version();
mix.sourceMaps().js('resources/js/admin.js', 'public/js').version();
mix.sourceMaps().js('resources/js/adminlte.min.js', 'public/js').version();

mix.sass('resources/sass/app.scss', 'public/css').version();
mix.css('resources/sass/adminlte.min.css', 'public/css');

mix.copyDirectory('resources/assets/fonts', 'public/fonts');
mix.copyDirectory('resources/assets/images', 'public/images');
mix.copyDirectory('vendor/tinymce/tinymce', 'public/js/tinymce');
