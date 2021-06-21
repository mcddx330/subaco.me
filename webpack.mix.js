const mix = require('laravel-mix');
//const tailwindcss = require('tailwindcss');
require('laravel-mix-purgecss');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

//mix.js('resources/js/app.js', 'public/js')
//    .sass('resources/sass/app.scss', 'public/css');

mix
    //.postCss('resources/css/app.css', 'public/css', [
    //    tailwindcss('./tailwind.config.js'),
    //    //require('postcss-import'),
    //    //require('tailwindcss'),
    //])
    //.purgeCss()

    /* raw css */
    //.styles(
    //    [
    //        'resources/css/base.css',
    //    ], 'public/css/style.css'
    //)
    .sass(
        'resources/css/base.scss', 'public/css/style.css')

    /* raw js */
    //.js(
    //    [
    //        //'resources/assets/js/bootstrap.js',
    //
    //    ], 'public/js/app.min.js'
    //)

    .js('resources/js/app.js', 'public/js')
;
