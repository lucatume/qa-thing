module.exports = {
	entry: "./assets/js/src/app-qa.js",
	output: {
		path: __dirname,
		filename: "./assets/js/qa-script.js"
	},
	module: {
		loaders: [
			{test: /\.css$/, loader: "style!css"}
		]
	}
};
