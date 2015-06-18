/**
 * Require Gulp
 */
var gulp = require('gulp');

/**
 * Require plugins
 */
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var minifycss = require('gulp-minify-css');
var rename = require('gulp-rename');
var autoprefixer = require('gulp-autoprefixer');
var copy = require('gulp-copy');
var plumber = require('gulp-plumber');

/**
 * Variables
 */
var bower_components = 'bower_components/';

/**
 * Compiles jQuery and jQuery UI
 */
gulp.task('jquery', function () {
    return gulp.src([
                bower_components + 'jquery/dist/jquery.min.js',
                bower_components + 'jquery-ui/jquery-ui.min.js'
            ])
            .pipe(concat('packaged.jquery.min.js'))
            .pipe(gulp.dest('assets/js/dist'))
});

/**
 * Compiles the SASS for distribution
 */
gulp.task('sass-dist', function () {
    return gulp.src('assets/css/src/app.scss')
            .pipe(plumber())
            .pipe(sass())
            .pipe(autoprefixer(
                'last 2 version',
                'safari 5',
                'ie 8',
                'ie 9',
                'opera 12.1'
            ))
            .pipe(rename({
                suffix: '.min'
            }))
            .pipe(minifycss())
            .pipe(gulp.dest('assets/css/dist/'))
});

/**
 * Compiles the JavaScripts for distribution
 */
gulp.task('scripts-dist', function () {
    return gulp.src([
                'assets/js/src/dev/*.js',
                bower_components + 'foundation/js/foundation/foundation.js',
                bower_components + 'foundation/js/foundation/foundation.equalizer.js'
            ])
            .pipe(concat('app.js'))
            .pipe(gulp.dest('assets/js/dist'))
            .pipe(rename('app.min.js'))
            .pipe(uglify())
            .pipe(gulp.dest('assets/js/dist'))
});

/**
 * Copies given bower components to the assets/js/dist directory
 */
gulp.task('scripts-copy', function () {
    return gulp.src([
                bower_components + 'jquery-ui/jquery-ui.min.js'
            ])
            .pipe(copy('assets/js/dist/', {
                prefix: 2
            }));
})

/**
 * Watch for changes
 * Recompile any changes to js or scss
 */
gulp.task('watch', function () {
    gulp.watch('assets/css/src/**/*.scss', ['sass-dist']);
    gulp.watch('assets/js/src/dev/*.js', ['scripts-dist']);
});

/**
 * Default task
 * Compiles sass, js and starts the watch task
 */
gulp.task('default', ['jquery', 'sass-dist', 'scripts-dist', 'scripts-copy', 'watch']);