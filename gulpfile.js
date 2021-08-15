const { series, src, dest } = require('gulp');
const uglify = require('gulp-uglify');
const rev = require('gulp-rev');
const sourcemaps =  require('gulp-sourcemaps');
const cssnano = require('cssnano');
const sass = require('gulp-sass')(require('sass'));
const postcss = require('gulp-postcss');
const plumber = require('gulp-plumber');
const autoprefixer = require('autoprefixer');
const postcssPlugins = [autoprefixer()];
const stylelint = require('stylelint');

// The `clean` function is not exported so it can be considered a private task.
// It can still be used within the `series()` composition.
function clean(cb) {
  // body omitted
  cb();
}

// The `build` function is exported so it is public and can be run with the `gulp` command.
// It can also be used within the `series()` composition.
function build(cb) {
  // body omitted
  cb();
}

function lint(cb) {
  return src('src/css/*.css')
  .pipe(sylelint)
}

function build_leo(cb) {
    return src('src/css/*.css')
    .pipe(postcss(postcssPlugins))
    .pipe(sourcemaps.init())
    .pipe(rev())
    .pipe(sourcemaps.write('.'))
    .pipe(dest('dist/'))
    .pipe(rev.manifest('manifest.json'))
    .pipe(dest('dist/'))
  }


exports.build_leo = build_leo;
exports.build = build;
exports.default = series(clean, build);