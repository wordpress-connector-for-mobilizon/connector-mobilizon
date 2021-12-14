/* eslint-disable no-undef */
const path = require('path')

const CopyPlugin = require('copy-webpack-plugin')

const PACKAGE = require('./package.json')

const FOLDER_SOURCE = './source'

module.exports = {
  entry: {
    'block-events-loader':
      FOLDER_SOURCE + '/' + PACKAGE.name + '/front/block-events-loader.js',
    'events-loader':
      FOLDER_SOURCE + '/' + PACKAGE.name + '/front/events-loader.js',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'build/' + PACKAGE.name + '/front'),
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
  plugins: [
    new CopyPlugin({
      patterns: [
        {
          context: FOLDER_SOURCE + '/' + PACKAGE.name,
          from: '**/*.php',
          to: '../',
        },
        {
          context: FOLDER_SOURCE + '/' + PACKAGE.name,
          from: '**/*.txt',
          to: '../',
        },
      ],
    }),
  ],
}
