/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // --- MARKETING ---
        mkt: { canvas: '#F9F8F6', teks: '#4A3F35', subteks: '#8C7A6B', mocha: '#D9C8B4', sand: '#F5EFE6', won: '#A3B8E1', wait: '#F2D680', reject: '#E5A9A9' },
        // --- DIREKTUR ---
        dir: { primary: '#C8B6A6', secondary: '#E8DED3', bg: '#FAF7F2', text: '#5B5650', accent: '#A89B8C' },
        // --- ENGINEERING ---
        eng: { primary: '#7D8FA6', sidebar: '#6F7FA8', bg: '#F8F9FC', card: '#FFFFFF', text: '#4B5563', border: '#E5EAF0', accent: '#CBB9A5', success: '#A4BEA1', warning: '#DDB892', danger: '#D7A6A6' },
        // --- PURCHASING ---
        pur: { primary: '#7B8FA8', sidebar: '#66758F', bg: '#F8FAFD', card: '#FFFFFF', text: '#4C5563', border: '#E7ECF3', accent: '#D9C7B8' }
      },
    },
  },
  plugins: [],
}