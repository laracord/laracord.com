/** @type {import('tailwindcss').Config} */

const colors = require('tailwindcss/colors')

module.exports = {
  darkMode: 'class',
  content: [
    './app/**/*.php',
    './config/**/*.php',
    './resources/**/*.{php,js}',
    './storage/framework/views/*.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
      colors: {
        primary: {
          DEFAULT: '#e5392a',
          50: '#f9d1cd',
          100: '#f7c0bb',
          200: '#f29e97',
          300: '#ee7d72',
          400: '#e95b4e',
          500: '#e5392a',
          600: '#bf2518',
          700: '#8d1c11',
          800: '#5b120b',
          900: '#290805',
          950: '#100302',
        },
      },
    },
  },
  plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
}
