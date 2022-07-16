import { defineConfig } from 'vite';
const path = require('path');

export default defineConfig({
    resolve: {
        alias: {
            'ziggy': '/vendor/tightenco/ziggy/src/js',
            'ziggy-vue': '/vendor/tightenco/ziggy/src/js/vue',
        },
    },
    build: {
        lib: {
          entry: path.resolve(__dirname, 'lib/main.js'),
          name: 'MyLib',
          fileName: (format) => `my-lib.${format}.js`
        },
        rollupOptions: {
          // make sure to externalize deps that shouldn't be bundled
          // into your library
          external: ['vue'],
          output: {
            // Provide global variables to use in the UMD build
            // for externalized deps
            globals: {
              vue: 'Vue'
            }
          }
        }
      }
});
