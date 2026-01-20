/** @type {import('tailwindcss').Config} */
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#98B67F", // Primary Green
                        secondary: "#B5A07C", // Secondary Gold
                        userblue: "#80B5D0", // User Blue
                        tertiary: "#E2C57F", // Tertiary Yellow
                        neutralgrey: "#9B8B9C", // Neutral Purple-Grey
                        "background-light": "#ffffff",
                        "background-dark": "#1a1c18",
                        "surface-light": "#f8f9f6",
                        "surface-dark": "#23261f",
                    },
                    fontFamily: {
                        display: ["Outfit", "sans-serif"],
                        body: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "12px",
                        xl: "24px",
                        "2xl": "32px",
                    },
                },
            },
        };
