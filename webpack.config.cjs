/* eslint-disable no-undef */
const path = require('path')

const CopyPlugin = require('copy-webpack-plugin')

const FOLDER_SOURCE = './source'

module.exports = {
  entry: {
    'block-events-loader': FOLDER_SOURCE + '/front/block-events-loader.js',
    'events-loader': FOLDER_SOURCE + '/front/events-loader.js',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'build/front'),
  },
  module: {
    rules: [
      {
        test: /\.m?js$/,
        exclude: /(node_modules)/,
        use: {
          loader: 'babel-loader',
        },
      },
    ],
  },
  module: {
    rules: [
      {
        test: /\.m?js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: [['@babel/preset-env', { targets: 'defaults' }]],
          },
        },
      },
    ],
  },
  plugins: [
    new CopyPlugin({
      patterns: [
        {
          context: FOLDER_SOURCE,
          from: '**/*.php',
          to: '../',
        },
        {
          context: FOLDER_SOURCE,
          from: '**/*.txt',
          to: '../',
        },
      ],
    }),
  ],
}
