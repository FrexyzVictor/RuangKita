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
                'resources/css/admin/users.css',
                'resources/js/admin/users.js',
                //auth                  
                'resources/css/auth/login.css',
                'resources/js/auth/login.js',

                'resources/css/auth/register.css',
                'resources/js/auth/register.js',

            ],
            refresh: true,
        }),
    ],
});
