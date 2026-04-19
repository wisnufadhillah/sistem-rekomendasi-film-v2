/** @type {import('tailwindcss').Config} */
module.exports = {
      content: ["./src/**/*.{html,js,php}", "./node_modules/flowbite/**/*.{js}", "./node_modules/preline/*.js"],
      theme: {
            extend: {
                  fontFamily: {
                        jersey: ["Jersey20", "sans-serif"],
                  },
                  backgroundImage: {
                        "custom-bg": "url('../images/background.png')",
                  },
                  backgroundSize: {
                        "full-cover": "cover",
                  },
                  backgroundPosition: {
                        "center-center": "center",
                  },
                  backgroundAttachment: {
                        fixed: "fixed",
                  },
                  colors: {
                        gold: "##F7A600",
                  },
                  padding: {
                        107: "107px",
                  },
            },
      },
};
