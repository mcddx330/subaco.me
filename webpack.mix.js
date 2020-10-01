const mix = require('laravel-mix');

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
    /* raw css */
    .styles(
        [
            'resources/css/normalize.css',
            'resources/css/skeleton.css',
            'resources/css/main.css',
        ], 'public/css/style.css'
    )

    /* raw js */
    //.js(
    //    [
    //        //'resources/assets/js/bootstrap.js',
    //
    //    ], 'public/js/app.min.js'
    //)

    .js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
;
