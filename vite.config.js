import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/css/app.css',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            'ziggy': '/resources/js/ziggy',
        },
    },
    build: {
        outDir: 'public/build', // Spécifiez le répertoire de sortie
        rollupOptions: {
            output: {
                // entryFileNames: `[name]-[hash].js`,
                // chunkFileNames: `[name]-[hash].js`,
                // assetFileNames: `[name]-[hash].[ext]`,
                entryFileNames: 'app.js', // Nom fixe pour le fichier JS principal
                chunkFileNames: 'chunk.js', // Nom fixe pour les fichiers de chunk
                assetFileNames: 'assets/[name].[ext]', // Nom fixe pour les autres assets (CSS, images, etc.)
            },
        },
    },
    base: '/build',
});
