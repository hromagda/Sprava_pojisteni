import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],

    build: {
        assetsInlineLimit: 0,  // To může pomoci s velkými soubory, aby byly správně zahrnuty
    },

    resolve: {
        alias: {
            '@images': path.resolve(__dirname, 'resources/images'), // Přidání aliasu pro images
        },
    },
});
