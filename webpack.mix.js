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

mix.options({
    hmrOptions: {
        host: '127.0.0.1',
        port: '8080',
        ignored: /node_modules/
    },
    watchOptions: {
        ignored: /node_modules/
    }
});

mix.webpackConfig({
    devServer: {
    	proxy: {
            '*': 'http://localhost:80'
        },
        port: '8080'
    }
});

mix.react('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');