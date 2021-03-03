module.exports = {
    context: `${process.env.WEBPACK_FOLDER}`,
    entry: {
        app: '/',
    },
    devtool: 'cheap-module-eval-source-map',
    outputFolder: `${process.env.PUBLIC_FOLDER}/app/themes/${process.env.WP_THEME_NAME}/assets/`,
    publicFolder: `${process.env.WEBPACK_FOLDER}/`,
    proxyTarget: `${process.env.WP_HOME}`,

    watch: [
        `${process.env.PUBLIC_FOLDER}/app/themes/${process.env.WP_THEME_NAME}/**/*.php`,
    ],
};
