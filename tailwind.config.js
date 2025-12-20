import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./app/Livewire/**/*.php",
    ],

    theme: {
        extend: {
          colors: {
            hg: {
              bg: '#F4F4F4',
              primary: '#00B7B5',
              secondary: '#018790',
              dark: '#005461',
            }
          },
          fontFamily: {
            sans: ['Figtree', 'sans-serif'],
          },
        },
      },

    plugins: [forms],
};