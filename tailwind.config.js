/** @type {import('tailwindcss').Config} */
import animations from "@midudev/tailwind-animations";

export default {
    content: [
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./public/**/*.blade.php",
        "./node_modules/flowbite/**/*.js",
    ],
    darkMode: "class",
    plugins: [
        animations,
        require("flowbite/plugin")({
            charts: false,
            forms: false,
            tooltips: false,
        }),
    ],
};
