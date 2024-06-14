import { defineConfig } from "vite"
export default defineConfig({
    base:'/dist',
    build: {
        manifest: true,
        rollupOptions:{
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
        },
    },
})