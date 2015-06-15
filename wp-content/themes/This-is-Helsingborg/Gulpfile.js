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
var plumber = require('gulp-plumber');

/**
 * Compiles the SASS for distribution
 */
gulp.task('sass-dist', function () {
    return gulp.src('assets/styles/src/app.scss')
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
            .pipe(gulp.dest('assets/styles/dist/'))
});

/**
 * Compiles the JavaScripts for distribution
 */
gulp.task('scripts-dist', function () {
    return gulp.src('assets/js/src/dev/*.js')
            .pipe(concat('packaged.js'))
            .pipe(gulp.dest('assets/js/dist'))
            .pipe(rename('packaged.min.js'))
            .pipe(uglify())
            .pipe(gulp.dest('assets/js/dist'))
});

/**
 * Watch for changes
 * Recompile any changes to js or scss
 */
gulp.task('watch', function () {
    gulp.watch('assets/styles/src/**/*.scss', ['sass-dist']);
    gulp.watch('assets/js/src/dev/*.js', ['scripts-dist']);
});

/**
 * Default task
 * Compiles sass, js and starts the watch task
 */
gulp.task('default', ['sass-dist', 'scripts-dist', 'watch']);