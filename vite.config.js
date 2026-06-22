import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});

// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import { bunny } from 'laravel-vite-plugin/fonts';

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: ['resources/css/app.css', 'resources/js/app.js'],
//             refresh: true,
//             fonts: [
//                 bunny('Instrument Sans', {
//                     weights: [400, 500, 600],
//                 }),
//             ],
//         }),
//     ],
//    server: {
//         host: '0.0.0.0', // Memaksa mendengarkan semua koneksi masuk
//         port: 5173,
//         strictPort: true,
//         hmr: {
//             host: https://organic-robot-7v4jp9r7px44hw6r6-5173.app.github.dev,
//             clientPort: 443, 
//             protocol: 'wss',
//         },
//     },
// });

// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import { bunny } from 'laravel-vite-plugin/fonts';

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: ['resources/css/app.css', 'resources/js/app.js'],
//             refresh: true,
//             fonts: [
//                 bunny('Instrument Sans', {
//                     weights: [400, 500, 600],
//                 }),
//             ],
//         }),
//     ],
//     server: {
//         host: '0.0.0.0', // Memaksa mendengarkan semua koneksi masuk
//         port: 5173,
//         strictPort: true,
//         hmr: {
//             // PAKAI TANDA KUTIP DAN HAPUS HTTPS://
//             host: 'organic-robot-7v4jp9r7px44hw6r6-5173.app.github.dev',
//             clientPort: 443, 
//             protocol: 'wss',
//         },
//     },
// });