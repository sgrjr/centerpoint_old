const mix = require('laravel-mix');
const path = require('path');

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

mix
.webpackConfig({

 stats:'detailed',
   devServer: {
      historyApiFallback: true
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                loader: "sass-loader",
                options: {
                    additionalData: '@import "resources/scss/_variables.scss";'
                }
            },
                     {
            test: /\.(js|jsx)$/,
            exclude: "/node-modules/",
            use: "babel-loader"

         },
         {
            test: /\.html$/,
            use: "html-loader"
         }
        ]
    }
})
.react()
.js('resources/js/app.js', 'public/js')
.sourceMaps(true, 'source-map')

.options({
    processCssUrls: false,
    stats: { 
        colors: true, 
        modules: true, 
        reasons: true, 
        errorDetails: true, 
        children:true 
    }
})
.sass('resources/scss/app.scss', 'public/css')
.version()
;