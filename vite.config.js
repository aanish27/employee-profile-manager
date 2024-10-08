import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/custom.sign-in.css',
                'resources/js/app.js',
                'resources/css/custom.data-table.css',
            ],
            refresh: true,
        }),
    ],
});
