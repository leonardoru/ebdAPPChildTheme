const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
const options = { 
    fileName: 'manifest.json',
    filter: ({ name }) => !name.endsWith('.map')
 };

  plugins: [
    new WebpackManifestPlugin(options)
  ]