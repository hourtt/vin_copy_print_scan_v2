import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/views/**/*.blade.php", "./resources/js/**/*.js"],

    theme: {
        extend: {
            fontFamily: {
                sans: [
                    '"Kantumruy Pro"',
                    "Noto Sans Khmer",
                    "Roboto",
                    ...defaultTheme.fontFamily.sans,
                ],
            },
            // Ticker Bar Animation
            keyframes: {
                "ticker-scroll": {
                    "0%": { transform: "translateX(0)" },
                    "100%": { transform: "translateX(-50%)" },
                },
            },
            animation: {
                "ticker-scroll": "ticker-scroll 30s linear infinite",
            },
        },
    },

    plugins: [forms],
};
