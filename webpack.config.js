const path = require('path');

const CopyPlugin = require('copy-webpack-plugin');

const PACKAGE = require('./package.json');

const FOLDER_SOURCE = './source';

module.exports = {
  entry: FOLDER_SOURCE + '/' + PACKAGE.name + '/front/events-loader.js',
  output: {
    filename: 'events-loader.js',
    path: path.resolve(__dirname, 'build/' + PACKAGE.name + '/front'),
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
};
