import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // essential
                'resources/css/components/_container.css',
                'resources/css/components/_navbar.css',
                'resources/css/components/_modal.css',
                'resources/css/components/_buttons.css',

                // need 
                'resources/css/login.css',
                'resources/css/dashboard.css'
            ],
            refresh: true,
        }),
    ],
});
