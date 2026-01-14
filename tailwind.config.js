/** @type {import('tailwindcss').Config} */
export default {
    content: {
        relative: true,
        transform: (content) => content.replace(/taos:/g, ""),
        files: [
            "./resources/**/*.blade.php",
            "./resources/**/*.js",
            "./resources/**/*.vue",
            "./node_modules/flowbite/**/*.js",
            "./src/*.{html,js}", 
        ],
    },
    safelist: [
        "!duration-[0ms]",
        "!delay-[0ms]",
        'html.js :where([class*="taos:"]:not(.taos-init))',
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require("taos/plugin"),
        require("flowbite/plugin")({
            charts: true,
        }),
    ],
    darkMode: "class",
};
