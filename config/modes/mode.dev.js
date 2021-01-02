const path = require('path');
const webpack = require('webpack');
const browserSync = require('browser-sync').create();
const dotEnv = require('dotenv').config()

const webpackDevMiddleware = require('webpack-dev-middleware');
const webpackHotMiddleware = require('webpack-hot-middleware');

const {publicFolder, proxyTarget, watch} = require('../project.config');
const webpackConfig = require('../webpack.config')({dev: true});
const getPublicPath = require('../publicPath');

const compiler = webpack(webpackConfig);


const middleware = [
	webpackDevMiddleware(compiler, {
		publicPath: getPublicPath(publicFolder),
		log: false,
		logLevel: 'silent',
		overlayWarnings: true,

		// quiet: true
	}),
	webpackHotMiddleware(compiler, {
		log: false,
		logLevel: 'none',
		overlayWarnings: true
	})
]

browserSync.init({
	middleware,
	proxy: {
		target: proxyTarget,
		middleware,
	},
	// open: 'external',
	open: false,
	files: watch.map(element => path.resolve(element)),
	snippetOptions: {
		rule: {
			match: /<\/head>/,
			fn: function (snippet, match) {
				return `
					${snippet}${match}
					<script defer src="${getPublicPath(publicFolder)}js/app.js"></script>
					<script defer src="${getPublicPath(publicFolder)}js/vendors.js"></script>
				`;
			}
		}
	}
});

