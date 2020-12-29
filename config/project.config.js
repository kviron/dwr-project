module.exports = {
	context: 'src',
	entry: {
		app: '/',
	},
	devtool: 'cheap-module-eval-source-map',
	outputFolder: `web/app/themes/${ process.env.WP_THEME_NAME }/assets/`,
	publicFolder: 'src/',
	proxyTarget: `${ process.env.WP_HOME }`,

	watch: [
		`web/app/themes/${ process.env.WP_THEME_NAME }/**/*.php`,
	],
};
