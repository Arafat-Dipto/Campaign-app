const { colors } = require("tailwindcss/defaultTheme");
const twColors = require("tailwindcss/colors");

module.exports = {
	content: ["./resources/views/**/*.blade.php", "./resources/js/frontend/**/*.js"],

	theme: {
		extend: {
			boxShadow: (theme) => ({
				outline: "0 0 0 2px " + theme("colors.primary"),
			}),
			colors: {
				gray: twColors.neutral,
				red: twColors.red,
				green: twColors.emerald,
				yellow: twColors.amber,
				purple: twColors.violet,
			},
		},
		colors: {
			...colors,
			primary: "#252526",
			secondary: "#11A6F8",
			white: "#FFFFFF",
			lightWhite: "rgba(255,255,255,0.7)",
			black: "#000000",
			lightBlack: "rgba(0,0,0,0.5)",
			background: "#EDF2F7",
			lightBackground: "#F7FAFC",
			border: "#E2E8F0",
			danger: "#E53E3E",
			current: "currentColor",
			transparent: "transparent",
		},
	},
	plugins: [],
};
