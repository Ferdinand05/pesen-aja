/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#4CAF50",
            },
            fontFamily: {
                Poppins: "Poppins",
            },
        },
    },
    plugins: [require("flowbite/plugin")],
};
