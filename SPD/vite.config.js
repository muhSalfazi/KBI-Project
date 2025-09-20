import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/css/style.css',
                'resources/assets/vendor/bootstrap/css/bootstrap.min.css',
                'resources/assets/vendor/boxicons/css/boxicons.min.css',
            ],
            refresh: true,
        }),
    ],
});
