//  webpack.config.js 
/*const glob = require("glob");

module.exports = {
    entry: glob.sync("./js/componentes/portada/*.js"),
    devtool: 'eval-source-map',
    output: {
        filename: './js/bundle.js',
        path: __dirname
    }
};*/

'use strict'
const { VueLoaderPlugin } = require('vue-loader')
module.exports = {
  mode: 'development',
  entry: [
    './js/vue/app.js',
  ],
  module: {
    rules: [
      {
        test: /\.vue$/,
        use: 'vue-loader'
      }
    ]
  },
  plugins: [
    new VueLoaderPlugin()
  ]
}