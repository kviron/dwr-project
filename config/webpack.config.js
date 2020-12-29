const path = require('path');
const Dotenv = require('dotenv-webpack');
const webpack = require('webpack');
const MiniCssExtractWebpackPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin');
const {context, entry, devtool, outputFolder, publicFolder} = require('./project.config');
const HMR = require('./hmr');
const getPublicPath = require('./publicPath');

module.exports = (options) => {
    const {dev, supportOldBrowsers} = options;
    const hmr = HMR.getClient();
    return {
        mode: dev ? 'development' : 'production',
        devtool: dev ? devtool : false,
        context: path.resolve(context),
        entry: {
            app: dev ? [hmr, entry.app] : [entry.app],
        },
        output: {
            path: path.resolve(outputFolder),
            publicPath: getPublicPath(publicFolder),
            filename: 'js/[name].js'
        },

        optimization: {
            splitChunks: {
                cacheGroups: {
                    vendor: {
                        name: 'vendors',
                        test: /[\\/]node_modules[\\/]/,
                        chunks: 'all',
                        enforce: true
                    }
                }
            },
            // runtimeChunk: dev,
            ...(!dev ?
                {
                    minimize: true,
                    minimizer: [
                        new TerserPlugin({
                            test: /\.js(\?.*)?$/i,
                            extractComments: false,
                            cache: true,
                            parallel: true

                        }),
                    ],
                } : [])


        },
        resolve: {
            extensions: [
                '.js',
                '.jsx',
                '.css',
                '.scss',
                '.jpg',
                '.jpeg',
                '.png',
                '.svg',
            ]
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: [
                        ...(dev ? [{loader: 'cache-loader'}] : []),
                        {
                            loader: 'babel-loader',
                            options: {
                                presets: [
                                    '@babel/preset-env'
                                ],
                                // plugins: [
                                //  '@babel/plugin-proposal-class-properties'
                                // ]
                            }
                        }
                    ]
                },
                {
                    test: /\.(sa|sc|c)ss$/,
                    use: [
                        ...(dev ? [
                            {
                                loader: 'style-loader'
                            },
                            {
                                loader: 'cache-loader'
                            },
                        ] : [
                            MiniCssExtractWebpackPlugin.loader
                        ]),
                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: true,
                            }
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                ident: 'postcss',
                                sourceMap: true,
                                config: {ctx: {dev, supportOldBrowsers}}
                            }
                        },
                        {
                            loader: 'resolve-url-loader',
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: true
                            }
                        }
                    ]
                },
                {
                    test: /\.svg$/,
                    include: [
                        path.resolve(context, "ico_sprite")
                    ],
                    use: [
                        {
                            loader: 'svg-sprite-loader',
                            options: {
                                extract: true,
                                // runtimeCompat: true,
                                // plainSprite: true,
                                esModule: false
                                // publicPath: '${getPublicPath( publicFolder )}/sprites/'
                            }
                        },
                        'svg-transform-loader',
                        {
                            loader: 'svgo-loader',
                            options: {
                                plugins: [
                                    {removeTitle: true},
                                    {convertColors: {shorthex: false}},
                                    {convertPathData: false},
                                    {removeAttrs: {attrs: '(stroke|fill)'}}
                                ]
                            }
                        }
                    ]
                },
                {
                    test: /\.(ttf|otf|eot|woff2?|svg|png|jpe?g|gif|ico|mp4|webm)$/,
                    exclude: /(ico_sprite)/,
                    use: [
                        {
                            loader: 'file-loader',
                            options: {
                                name: '[path][name].[ext]',
                            }
                        }
                    ]
                },

            ]
        },
        plugins: [
            ...(dev ? [
                new Dotenv({
                        systemvars: true,
                    }
                ),
                new webpack.HotModuleReplacementPlugin(),
                new FriendlyErrorsWebpackPlugin(),
                new webpack.SourceMapDevToolPlugin({
                    filename: '[file].map'
                }),
                new SpriteLoaderPlugin({}),

            ] : [
                new MiniCssExtractWebpackPlugin({
                    filename: 'css/[name].css',
                }),
                new CopyWebpackPlugin([
                    path.resolve(outputFolder)
                ], {
                    allowExternal: true,
                    beforeEmit: true
                }),
                new CopyWebpackPlugin([
                    {
                        from: path.resolve(`${context}/**/*`),
                        to: path.resolve(outputFolder),
                    }
                ], {
                    ignore: ['*.js', '*.scss', '*.css', '**/ico_sprite/*svg', '*jsx']
                }),
                new SpriteLoaderPlugin({
                    plainSprite: true
                }),
            ])
        ]
    }
}
