/* eslint-disable no-undef */
const path = require('path')

const CopyPlugin = require('copy-webpack-plugin')

const FOLDER_SOURCE = './source'

module.exports = {
  entry: FOLDER_SOURCE + '/front/events-loader.js',
  output: {
    filename: 'events-loader.js',
    path: path.resolve(__dirname, 'build/' + '/front'),
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
