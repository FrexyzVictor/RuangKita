import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                //admin
                'resources/css/admin/admin.css',
                'resources/js/admin/admin.js',
                //booking
                'resources/css/admin/booking.css',
                'resources/js/admin/booking.js',
                //user


            ],
            refresh: true,
        }),
    ],
});
