/* eslint-disable no-undef */
const { dest, src } = require('gulp')

const replace = require('gulp-replace')

const PACKAGE = require('./package.json')

const FOLDER_BUILD = './build'

function injectMetadata() {
  return src(
    [
      FOLDER_BUILD + '/front/block-events-loader.js',
      FOLDER_BUILD + '/front/events-loader.js',
      FOLDER_BUILD + '/' + PACKAGE.name + '.php',
      FOLDER_BUILD + '/includes/constants.php',
      FOLDER_BUILD + '/readme.txt',
    ],
    { base: './' }
  )
    .pipe(replace('<wordpress-author-name>', PACKAGE.author.name))
    .pipe(replace('<wordpress-author-url>', PACKAGE.author.url))
    .pipe(replace('<wordpress-description>', PACKAGE.description))
    .pipe(replace('<wordpress-donation-link>', PACKAGE.funding.url))
    .pipe(replace('<wordpress-license>', PACKAGE.license))
    .pipe(
      replace(
        '<wordpress-minimum-version>',
        PACKAGE.additionalDetails.wordpressMinimumVersion
      )
    )
    .pipe(replace('<wordpress-name>', PACKAGE.name))
    .pipe(replace('<wordpress-nice-name>', PACKAGE.additionalDetails.niceName))
    .pipe(
      replace(
        '<wordpress-php-minimum-version>',
        PACKAGE.additionalDetails.phpMinimumVersion
      )
    )
    .pipe(
      replace(
        '<wordpress-tested-up-to-version>',
        PACKAGE.additionalDetails.wordpressTestedUpToVersion
      )
    )
    .pipe(replace('<wordpress-version>', PACKAGE.version))
    .pipe(dest('.'))
}

exports.inject = injectMetadata
