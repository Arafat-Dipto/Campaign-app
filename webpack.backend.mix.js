const mix = require("laravel-mix");
const path = require("path");
const tailwindcss = require("tailwindcss");
require("laravel-mix-merge-manifest");

// THIS IS A TEMPORARY SOLUTION.
const { hmrOptions, devServer } = require("./webpack.fix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.extract();

mix.js("resources/js/backend/app.js", "public/js/backend")
	.react()
	.postCss("resources/css/backend/app.css", "public/css/backend/app.css", [
		require("postcss-import"), //
		tailwindcss("./tailwind.backend.config.js"),
		require("autoprefixer"),
	])
	.options({
		hmrOptions: hmrOptions,
	})
	.webpackConfig({
		output: { chunkFilename: "js/backend/[name].js?id=[chunkhash]" },
		resolve: {
			alias: {
				"@": path.resolve("resources/js/backend"),
			},
		},
		devServer: devServer,
	})
	.version()
	.sourceMaps()
	.mergeManifest();
