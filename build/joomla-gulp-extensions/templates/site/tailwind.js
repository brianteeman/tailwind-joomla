var gulp      = require('gulp');
var config    = require('../../../gulp-config.json');
var extension = require('../../../package.json');

// Dependencies
var beep        = require('beepbeep');
var browserSync = require('browser-sync');
var cleanCSS    = require('gulp-clean-css');
var concat      = require('gulp-concat');
var del         = require('del');
var gutil       = require('gulp-util');
var path        = require('path');
var plumber     = require('gulp-plumber');
var rename      = require('gulp-rename');
var postcss     = require('gulp-postcss');
var sass        = require('gulp-sass');
var uglify      = require('gulp-uglify');
var tailwindcss = require('tailwindcss');

var tplName   = "tailwind";
var tplBase   = "site";
var tplFolder = 'tpl_' + tplName;

var baseTask  = 'templates.frontend.' + tplName;
var extPath   = '../extensions/templates/' + tplBase + '/' + tplName;
var mediaPath = extPath + '/media/' + tplFolder;
var assetsPath = './media/templates/' + tplBase + '/' + tplFolder;
var nodeModulesPath = './node_modules';

var wwwPath = config.wwwDir + '/templates/' + tplName;

var onError = function (err) {
    beep([0, 0, 0]);
    gutil.log(gutil.colors.green(err));
};

// Clean
gulp.task('clean:' + baseTask,
	[
		'clean:' + baseTask + ':template'
	]
);

// Clean: Template
gulp.task('clean:' + baseTask + ':template', function() {
	return del(wwwPath, {force : true});
});

// Copy
gulp.task('copy:' + baseTask,
	[
		'clean:' + baseTask,
		'copy:' + baseTask + ':template'
	],
	function() {
	});

// Copy: Template
gulp.task('copy:' + baseTask + ':template', ['clean:' + baseTask + ':template'], function() {
	return gulp.src([
			extPath + '/**'
		])
		.pipe(gulp.dest(wwwPath));
});

function compileScripts(src, ouputFileName, destinationFolder) {
	return gulp.src(src)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(concat(ouputFileName))
		.pipe(gulp.dest(extPath + '/' + destinationFolder))
		.pipe(gulp.dest(wwwPath + '/' + destinationFolder))
		.pipe(uglify())
		.pipe(rename(function (path) {
			path.basename += '.min';
		}))
		.pipe(gulp.dest(extPath + '/' + destinationFolder))
		.pipe(gulp.dest(wwwPath + '/' + destinationFolder))
		.pipe(browserSync.reload({stream:true}));
}

// Scripts
gulp.task('scripts:' + baseTask,
	[
		'scripts:' + baseTask + ':template'
	]
);

// Scripts
gulp.task('scripts:' + baseTask + ':template', function () {

	return compileScripts(
		[
			assetsPath + '/js/template.js'
		],
		'scripts.js',
		'assets/js'
	);
});

function compileSassFile(src, destinationFolder, options)
{
	return gulp.src(src)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(sass())
	    .pipe(postcss([
	      tailwindcss('./tailwind.js'),
	      require('autoprefixer'),
	    ]))
		.pipe(gulp.dest(extPath + '/' + destinationFolder))
		.pipe(gulp.dest(wwwPath + '/' + destinationFolder))
		.pipe(browserSync.reload({stream:true}))
		.pipe(cleanCSS({compatibility: 'ie8'}))
		.pipe(rename(function (path) {
			path.basename += '.min';
		}))
		.pipe(gulp.dest(extPath + '/' + destinationFolder))
		.pipe(gulp.dest(wwwPath + '/' + destinationFolder))
		.pipe(browserSync.reload({stream:true}));
}

// Sass
gulp.task('sass:' + baseTask, function () {
	return compileSassFile(
		assetsPath + '/scss/template.scss',
		'assets/css'
	);
});

// Watch
gulp.task('watch:' + baseTask,
	[
		'watch:' + baseTask + ':template',
		'watch:' + baseTask + ':scripts',
		'watch:' + baseTask + ':sass'
	],
	function() {
	});

// Watch: Template
gulp.task('watch:' + baseTask + ':template', function() {
	gulp.watch([
			extPath + '/**/*',
			'!' + extPath + '/assets',
			'!' + extPath + '/assets/**/*'
		],
		['copy:' + baseTask + ':template', browserSync.reload]);
});

// Watch: Scripts
gulp.task('watch:' + baseTask + ':scripts', function() {
	gulp.watch([
			assetsPath + '/js/**/*.js'
		],
		['scripts:' + baseTask, browserSync.reload]);
});

// Watch: Sass
gulp.task('watch:' + baseTask + ':sass', function() {
	gulp.watch([
			assetsPath + '/scss/**/*.scss'
		],
		['sass:' + baseTask, browserSync.reload]);
});

