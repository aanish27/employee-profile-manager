import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    optimizeDeps: {
        exclude: ['js-big-decimal']
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/custom.sign-in.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
