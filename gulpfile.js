var gulp = require('gulp');
var rename = require('gulp-rename');
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var cache = require('gulp-cache');
var order = require('gulp-order');
var sass = require('gulp-sass');
var del = require('del');
var util = require('gulp-util');
var sourcemaps = require('gulp-sourcemaps');
var notify = require('gulp-notify');
var source = require('vinyl-source-stream');
var minifyCss = require('gulp-minify-css');
var sourcemaps = require('gulp-sourcemaps');
var sassdoc = require('sassdoc');
var gap = require('gulp-append-prepend');


gulp.task('styles', function(){
  gulp.src(['src/scss/site.scss'])
    .pipe(sass({outputStyle: 'expanded'}).on('error', handleErrors))
    .pipe(autoprefixer('> 0%'))
    .pipe(rename('site.css'))
    .pipe(gulp.dest('www/wordpress/wp-content/themes/bigcitymountaineers/assets/css/'))
    .pipe(minifyCss())
    .pipe(rename('site.min.css'))
    .pipe(gulp.dest('www/wordpress/wp-content/themes/bigcitymountaineers/assets/css/'));
});


gulp.task('scripts', function(){
  return gulp.src([
    "src/js/lazyload.js",
    "src/js/scrollIntoView.polyfill.js",
    "src/js/site.js"])
    .pipe(sourcemaps.init())
    .pipe(concat("site.min.js"))
    .pipe(sourcemaps.write())
    .pipe(uglify({mangle: true}).on('error', handleErrors))
    .pipe(gulp.dest('www/wordpress/wp-content/themes/bigcitymountaineers/assets/js/'));
});

gulp.task('sassdoc', function () {
  var options = {
    dest: 'src/scss/sassdoc'
  }
  return gulp.src('src/scss/**/*.scss')
    .pipe(sassdoc(options));
});

/*
  Error Handler
*/
function handleErrors() {
var args = Array.prototype.slice.call(arguments);
notify.onError({
title: 'Compile Error',
message: '<%= error.message %>'
}).apply(this, args);
this.emit('end'); // Keep gulp from hanging on this task
}

function log(msg) {
	if(typeof(msg) === 'object') {
		for(var item in msg) {
			if(msg.hasOwnProperty(item)) {
				util.log(util.colors.blue(msg[item]));
			}
		}
	} else {
		util.log(util.colors.blue(msg));
	}
}

function errorLogger(error) {
	log("*** Start Error ***");
	log(error);
	log("*** End ***");
	this.emit('end');
}


gulp.task('default', function(){
  gulp.watch('src/scss/**/*.scss', ['styles', 'sassdoc']);
  gulp.watch("src/js/**/*.js", ['scripts']);
});
