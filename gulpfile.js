// Include Gulp & plugins
// $ gulp-install.sh
var gulp           = require('gulp');
var mainBowerFiles = require('gulp-main-bower-files');
var addSrc         = require('gulp-add-src');  // .pipe(addSrc('www/bower_files/foo.js'))
var order          = require('gulp-order');
var concat         = require('gulp-concat');
var filter         = require('gulp-filter');
var uglify         = require('gulp-uglify');
var cleanCSS       = require('gulp-clean-css');

// Settings
var dest = 'www/bower_components/';

var bowerOptions = {overrides: {
	'jquery': {main: [
		'dist/jquery.js',  // for jQuery 2.*
		'jquery.js',       // for jQuery 1.*
		'jquery.migrate.js',
	]},
	'bootstrap': {main: [
		'dist/js/bootstrap.js',
		'dist/css/bootstrap.css',
		'dist/css/bootstrap-theme.css',
	]},
	'jquery-ui': {main: [
		'jquery-ui.js',
		'themes/base/all.css',
	]},
	'select2': {main: [
		"dist/js/select2.js",
        "dist/css/select2.css"
	]},
	'moment': {main: [
		"moment.js",
        "locale/*.js",
	]},
	'fine-uploader': {main: [
		"dist/fine-uploader.js",
		"dist/fine-uploader.map.js",
		"dist/fine-uploader-new.css",
	]},
	'ckeditor': {main: [
		"ckeditor.js",
		"adapters/jquery.js",
	]},
	'nette.ajax.js': {main: [
		"nette.ajax.js",
		"extensions/spinner.ajax.js",
	]},
	'bootstrap-languages': {main: [
		"languages.min.css",
	]},
}};


// Tasks
gulp.task('css', function() {
	gulp.src('./bower.json')
		.pipe(mainBowerFiles(bowerOptions))
		.pipe(filter('**/*.css'))
		// .pipe(addSrc('www/bower_files/bootstrap-languages/languages.min.css'))
		.pipe(cleanCSS({rebaseTo: dest}))
		.pipe(concat('all.min.css'))
		.pipe(gulp.dest(dest));
});

gulp.task('js', function() {
	gulp.src('./bower.json')
		.pipe(mainBowerFiles(bowerOptions))
		.pipe(filter('**/*.js'))
		.pipe(order([
			'**/jquery/dist/jquery.js',  // for jQuery 2.*
			'**/jquery/jquery.js',       // for jQuery 1.*
			'**/nette.ajax.js',
			'**/moment/moment.js',
			'**/moment/locale/*.js',
			'**/jquery-ui/**',
			'**/ckeditor/ckeditor.js',
			'**/*',
		]))
		// .pipe(uglify())
		.pipe(concat('all.min.js'))
		.pipe(gulp.dest(dest));
});

gulp.task('default', ['css', 'js']);
