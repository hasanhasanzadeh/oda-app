import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/pwa.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: 'localhost',
        },
    },
    build: {
        // Optimize for PWA
        target: 'es2015',
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
            },
        },
        rollupOptions: {
            output: {
                // Optimize chunk splitting for PWA
                manualChunks: (id) => {
                    // Create chunks for better caching
                    if (id.includes('node_modules')) {
                        if (id.includes('alpinejs')) {
                            return 'alpine';
                        }
                        if (id.includes('@fortawesome')) {
                            return 'fontawesome';
                        }
                        return 'vendor';
                    }
                },
                // Add hash to filenames for better caching
                chunkFileNames: 'assets/[name]-[hash].js',
                entryFileNames: 'assets/[name]-[hash].js',
                assetFileNames: 'assets/[name]-[hash].[ext]',
            },
        },
        // Increase chunk size warning limit for PWA
        chunkSizeWarningLimit: 1000,
    },
    // Optimize dependencies for PWA
    optimizeDeps: {
        include: [
            'alpinejs',
            '@fortawesome/fontawesome-free',
        ],
    },
    // CSS optimization
    css: {
        devSourcemap: true,
    },
});
