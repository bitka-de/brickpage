import { defineConfig } from 'vite'

export default defineConfig({
  root: '.',
  publicDir: false,  // Deaktiviere public directory feature, da wir in public/ ausgeben
  build: {
    outDir: 'public/src',        // Kompilierte Dateien landen in public/src
    emptyOutDir: true,
    rollupOptions: {
      input: 'app/assets/js/app.js'  // Einstiegspunkt für die Kompilierung
    }
  },
  server: {
    host: 'localhost',
    port: 3000,
    cors: {
      origin: ['http://brickpage.test', 'http://localhost:8000'],
      credentials: true
    }
  }
})