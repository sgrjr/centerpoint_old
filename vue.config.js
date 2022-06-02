module.exports = {
  css: {
    loaderOptions: {
      sass: {
        additionalData: `
          @import "@/resources/scss/_variables.scss";
        `
      }
    }
  },

  chainWebpack: config => {
    config.module
      .rule('vue')
      .use('vue-loader')
      .tap(options => ({
        ...options,
        compilerOptions: {
          // treat any tag that starts with ion- as custom elements
          isCustomElement: tag => tag.startsWith('ion-')
        }
      }))
  }
};