const { dest, series, src } = require('gulp');

const del = require('del');
const replace = require('gulp-replace');
const webpack = require('webpack-stream');

const PACKAGE = require('./package.json');

const FOLDER_SOURCE = './source'
const FOLDER_BUILD = './build';

let mode = 'development';


function clean(cb) {
  del(FOLDER_BUILD);
  cb();
}

const eventsLoaderOutputPath = PACKAGE.name + '/front/events-loader';
const eventsLoaderInputPath = FOLDER_SOURCE + '/' + PACKAGE.name + '/front/events-loader.js';

function bundleFrontend() {
  return src(FOLDER_SOURCE + '/' + PACKAGE.name + '/front/events-loader.js')
    .pipe(webpack({
      mode,
      entry: {
        [eventsLoaderOutputPath]: eventsLoaderInputPath,
      },
      output: {
        filename: '[name].js',
      },
    }))
    .pipe(dest(FOLDER_BUILD));
  }

function copyBackend() {
  return src([
    FOLDER_SOURCE + '/**/*.php',
    FOLDER_SOURCE + '/**/*.txt'
  ])
    .pipe(dest(FOLDER_BUILD));
}

function injectMetadata() {
  return src([
    FOLDER_BUILD + '/' + eventsLoaderOutputPath + '.js',
    FOLDER_BUILD + '/' + PACKAGE.name + '/' + PACKAGE.name + '.php',
    FOLDER_BUILD + '/' + PACKAGE.name + '/includes/constants.php',
    FOLDER_BUILD + '/' + PACKAGE.name + '/readme.txt'
  ], { base: './' })
    .pipe(replace('<wordpress-author-name>', PACKAGE.author.name))
    .pipe(replace('<wordpress-author-url>', PACKAGE.author.url))
    .pipe(replace('<wordpress-description>', PACKAGE.description))
    .pipe(replace('<wordpress-license>', PACKAGE.license))
    .pipe(replace('<wordpress-minimum-version>', PACKAGE.additionalDetails.wordpressMinimumVersion))
    .pipe(replace('<wordpress-name>', PACKAGE.name))
    .pipe(replace('<wordpress-nice-name>', PACKAGE.additionalDetails.niceName))
    .pipe(replace('<wordpress-php-minimum-version>', PACKAGE.additionalDetails.phpMinimumVersion))
    .pipe(replace('<wordpress-tested-up-to-version>', PACKAGE.additionalDetails.wordpressTestedUpToVersion))
    .pipe(replace('<wordpress-version>', PACKAGE.version))
    .pipe(dest('.'));
}

exports.front = bundleFrontend;
exports.copy = copyBackend;
exports.inject = injectMetadata;

const build = series(clean, bundleFrontend, copyBackend, injectMetadata);

const buildDev = series((cb) => { mode = 'development'; cb(); }, build);

const buildProd = series((cb) => { mode = 'production'; cb(); }, build);


exports.clean = clean;
exports.dev = buildDev;
exports.default = buildDev;
exports.prod = buildProd;
