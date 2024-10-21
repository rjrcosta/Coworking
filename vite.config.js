import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/appLogin.css',
                'resources/css/bookForm.css',
                'resources/js/app.js',
                'resources/js/bookForm.js',
            ],
            refresh: true,
        }),
    ],
});
