const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
require('babel-polyfill');

module.exports = {
    plugins: [new MiniCssExtractPlugin({
        filename: '[name].bundle.css',
    })],
    entry: {
        admin: './assets/src/admin/index.js',
        frontend: './assets/src/frontend/index.js',
        editor: './assets/src/editor/index.js',
    },
    output: {
        filename: '[name].bundle.js',
        path: path.resolve(__dirname, 'assets/dist'),
    },
    module: {
        rules: [
            {
                test: /\.s[ac]ss$/i,
                use: [
                  // Creates `style` nodes from JS strings
                  'style-loader',
                  // Translates CSS into CommonJS
                  'css-loader',
                  // Compiles Sass to CSS
                  'sass-loader',
                ],
            },
            {
                test: /\.(js|jsx)$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            '@babel/preset-env',
                            '@babel/preset-react'
                        ]
                    }
                  }
            }
        ],
    },
    resolve: {
        extensions: ['*', '.js', '.jsx']
    },
    mode: 'development',
	optimization: {
		splitChunks: {
			cacheGroups: {
				vendors: {
					priority: -10,
					test: /[\\/]node_modules[\\/]/
				}
			},
			chunks: 'async',
			minChunks: 1,
			minSize: 30000,
			name: true
		}
	}
};