var gulp = require('gulp'),
    autoprefixer = require('autoprefixer'),
    plumber = require( 'gulp-plumber' ),
    watch = require( 'gulp-watch' ),
    livereload = require( 'gulp-livereload' ),
    minifycss = require( 'gulp-cssnano' ),
    uglify = require( 'gulp-uglify' ),
    rename = require( 'gulp-rename' ),
    notify = require( 'gulp-notify' ),
    include = require( 'gulp-include' ),
    sass = require( 'gulp-sass' ),
    concat = require('gulp-concat'),
    postcss = require('gulp-postcss'),
    mqpacker = require('css-mqpacker'),
    imagemin = require('gulp-imagemin'),
    sprity = require('sprity'),
    gulpif = require('gulp-if'),
    sourcemaps = require('gulp-sourcemaps'),
    wpPot = require('gulp-wp-pot');

var onError = function( err ) {
    console.log( 'An error occurred:', err.message );
    this.emit( 'end' );
};

var src = './assets/';
var dest = './assets/';

var paths = {
    /* Source paths */
    styles: src + 'css/**/*.scss',
    adminStyles: './admin/css/**/*.scss',
    adminScripts: './admin/js/',
    scripts: src + 'js/',

    /* Output paths */
    stylesOutput: dest + 'css/',
    scriptsOutput: dest + 'js/',
    adminStylesOutput: './admin/css/',
    adminScriptsOutput: './admin/js/',
};


gulp.task( 'styles', function() {
    return gulp.src( paths.styles, {
        style: 'expanded'
    } )
    .pipe( plumber( { errorHandler: onError } ) )
    .pipe( sass() )
    .pipe( gulp.dest( './' ) )
    .pipe(postcss([
        autoprefixer({
            browsers: ['last 2 version']
        }),
        mqpacker({
            sort: true
        }),
    ]))
    .pipe(sourcemaps.init())
    .pipe( minifycss() )
    .pipe(sourcemaps.write())
    .pipe( rename( { suffix: '.min' } ) )
    .pipe( gulp.dest( paths.stylesOutput ) )
    .pipe( notify( { message: 'Styles task complete' } ) );
});

gulp.task( 'admin-styles', function() {
    return gulp.src( paths.adminStyles, {
        style: 'expanded'
    } )
    .pipe( plumber( { errorHandler: onError } ) )
    .pipe( sass() )
    .pipe( gulp.dest( paths.adminStylesOutput ) )
    .pipe(postcss([
        autoprefixer({
            browsers: ['last 2 version']
        }),
        mqpacker({
            sort: true
        }),
    ]))
    .pipe(sourcemaps.init())
    .pipe( minifycss() )
    .pipe(sourcemaps.write())
    .pipe( rename( { suffix: '.min' } ) )
    .pipe( gulp.dest( paths.adminStylesOutput ) )
    .pipe( notify( { message: 'Styles task complete' } ) );
});

gulp.task('scripts', function(){
  return gulp.src(paths.scripts)
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(paths.scriptsOutput))
      .pipe( notify( { message: 'Script task complete' } ) );
});

gulp.task( 'watch', function() {
    livereload.listen();
    gulp.watch( paths.styles, [ 'styles' ] );
    gulp.watch( paths.scripts, [ 'scripts' ] );
    gulp.watch( paths.adminStyles, [ 'admin-styles' ] );
} );

gulp.task( 'default', [ 'watch', 'styles', 'scripts', 'admin-styles'], function() {});
