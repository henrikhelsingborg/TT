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
 * Compile sass
 */
gulp.task('sass-dist', function () {
    return gulp.src([
                'scss/app.scss'
            ])
            .pipe(plumber())
            .pipe(concat('app.css'))
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
            .pipe(gulp.dest('css'))
});

/**
 * Compiles js
 */
gulp.task('scripts-dev', function () {
    return gulp.src([
                'js/dev/hbg-school.dev.js',
                'js/dev/translate.dev.js',
                bower_components + 'modernizr/modernizr.js',
                bower_components + 'foundation/js/foundation.min.js',
                bower_components + 'foundation/js/foundation/foundation.orbit.js',
                bower_components + 'js/plugins/*.js',
                bower_components + 'js/dev/*.js'
            ])
            .pipe(concat('app.js'))
            .pipe(gulp.dest('js'))
            .pipe(rename('app.min.js'))
            .pipe(uglify())
            .pipe(gulp.dest('js'));
});

/**
 * Compile jQuery
 */
gulp.task('scripts-jquery', function () {
    return gulp.src([
                'js/jquery/dist/jquery.min.js',
                'js/jquery/dist/jquery-ui.min.js'
            ])
            .pipe(concat('jquery.app.js'))
            .pipe(gulp.dest('js'))
            .pipe(rename('jquery.app.min.js'))
            .pipe(uglify())
            .pipe(gulp.dest('js'));
});




gulp.task('scripts-dist', ['scripts-dev', 'scripts-jquery']);


/**
 * Watch for changes
 * Recompile any changes to js or scss
 */
gulp.task('watch', function () {
    gulp.watch('scss/**/*.scss', ['sass-dist']);
    gulp.watch(['js/**/*.js', '!js/app.js', '!js/app.min.js'], ['scripts-dev']);
});


gulp.task('default', ['sass-dist', 'scripts-dist']);
