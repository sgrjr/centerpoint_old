const mix = require('laravel-mix');
const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
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
   plugins: [new MiniCssExtractPlugin({filename:"style.css",chunkFilename:"[name].css"})],
   devServer: {
      historyApiFallback: true
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                loader: "sass-loader",
                options: {
                    additionalData: '@import "resources/scss/variables.scss";'
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
         },
         {
           test: /\.(sa|sc|c)ss$/,
           use: [
             MiniCssExtractPlugin.loader,
             // Translates CSS into CommonJS
             "css-loader",
             // Compiles Sass to CSS
             "sass-loader",
           ],
         },
        ]
    }
})
.js('resources/js/app.js', 'public/js')
.js('resources/js/first/first.js', 'public/js')
.sourceMaps(true, 'source-map')
.react()
.vue(3)
.sass('resources/scss/app.scss', 'public/css')
.options({
    processCssUrls: false,
    stats: { colors: true, modules: true, reasons: true, errorDetails: true, children:true }
})
.version()
;
