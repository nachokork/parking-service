import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    host: '0.0.0.0', // Esto permite que Vite acepte conexiones desde cualquier IP (no solo localhost)
    port: 5173,
  },
})