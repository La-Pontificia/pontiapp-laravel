/** @type {import('tailwindcss').Config} */

export default {
    content: [
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./public/**/*.blade.php",
        "./node_modules/flowbite/**/*.js",
    ],
    darkMode: 'media',
    plugins: [require("flowbite/plugin")],
};
