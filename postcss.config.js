module.exports = ({options}) => {
	return ({
		plugins: {
			'autoprefixer': options.supportOldBrowsers ? { grid: "autoplace" } : {} ,
			'postcss-preset-env': {},
			'css-mqpacker': {sort: true},
			'cssnano': options.dev ? false : {
				preset: ['default', {
					discardComments: { removeAll: true }
				}]
			},
			'postcss-pxtorem': !options.dev ? ({ replace: true, rootValue: 16 }) : false,
		}
	})
};
