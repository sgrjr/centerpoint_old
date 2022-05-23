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
mix.webpackConfig({
    devServer: {
      historyApiFallback: true
    },
    module:{
        rules: [
            {
                test: /\.scss$/,
                loader: "sass-loader",
                options: {
                    additionalData: '@import "resources/js/src/_variables.scss";'
                }
            }
        ]
    }
});

mix.options({
    stats: { colors: true, modules: true, reasons: true, errorDetails: true, children:true }
})
	.js('resources/js/app.js', 'public/js')
	.sourceMaps(true, 'source-map')
    .react()
    .sass('resources/sass/app.scss', 'public/css')
    .version()
    .options({processCssUrls: false, stats:{children:true}})
    ;
