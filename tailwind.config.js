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
      colors: {
        primary: colors.orange,
      },
    },
  },
  plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
}
