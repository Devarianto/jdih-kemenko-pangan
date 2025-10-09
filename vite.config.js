import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import liveReload from 'vite-plugin-live-reload';
import fg from 'fast-glob';
import { resolve } from 'path';
import inject from "@rollup/plugin-inject";

export default defineConfig({
  plugins: [
    inject({   // => that should be first under plugins array
      $: 'jquery',
      jQuery: 'jquery',
      include: ['./resources/assets/js/**/*.js'],
    }),
    laravel({
      input: [
        // 'resources/css/app.css',
        // 'resources/js/app.js'
        ...fg.sync('./resources/assets/js/**/*.js'),
        ...fg.sync('./resources/assets/css/**/*.css'),
        ...fg.sync('./resources/assets/sass/**/*.scss'),
        ...fg.sync('./resources/assets/sass/**/*.sass'),
        ...fg.sync('./resources/assets/images/**/*.{webp,avif,svg,jpg,png}'),
      ],
      refresh: true,
    }),
    liveReload([
      ...fg.sync('resources/views/**/*.blade.php')
      // 'resources/views/welcome.blade.php',
    ]),
  ],
  resolve: {
    alias: {
      '@': resolve(__dirname, 'resources'),
      '@css': resolve(__dirname, 'resources/assets/css'),
      '@js': resolve(__dirname, 'resources/assets/js'),
      '@sass': resolve(__dirname, 'resources/assets/sass'),
      '@fonts': resolve(__dirname, 'resources/assets/fonts'),
      '@images': resolve(__dirname, 'resources/assets/images'),
      jquery: resolve(__dirname, 'node_modules/jquery/dist/jquery.min.js'),
    },
  },
  css: {
    devSourcemap: true,
    preprocessorOptions: {
      scss: {
        sourceMap: true,
      },
    },
  },
  optimizeDeps: {
    include: ['jquery'],
  },
});
