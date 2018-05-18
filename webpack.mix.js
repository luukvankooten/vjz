let mix = require('laravel-mix');
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

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/jQuery.js', 'public/js')
    .less('resources/assets/less/app.less', 'public/css')
    .less('resources/assets/less/login.less', 'public/css')
    .less('resources/assets/less/form.less', 'public/css')
    .copyDirectory('resources/assets/fonts', 'public/fonts')
    .js('resources/assets/js/Vue.js', 'public/js')
    .js('resources/assets/js/components.js', 'public/js')
    .browserSync('https://vjz.dev');
