const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
   stats:'detailed',
   entry: "./resources/js/app.js",
   output: {
      filename: "bundle.js",
      path: path.resolve("./public/dist")
   },
   plugins: [new MiniCssExtractPlugin({filename:"style.css",chunkFilename:"[name].css"})],
   module: {
      rules: [
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

}