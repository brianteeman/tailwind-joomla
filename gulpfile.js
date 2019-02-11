var gulp      = require('gulp');
var config    = require('./gulp-config.json');
var extension = require('./package.json');

var defaultBrowserConfig = {
	proxy : "localhost"
}

// Keep B/C support for old browserSyncProxy setting
if (config.hasOwnProperty('browserSyncProxy'))
{
	defaultBrowserConfig.proxy = config.browserSyncProxy;
}

var browserConfig = config.hasOwnProperty('browserConfig') ? config.browserConfig : defaultBrowserConfig;

// Dependencies
var beep        = require('beepbeep');
var browserSync = require('browser-sync');
var cleanCSS    = require('gulp-clean-css');
var concat      = require('gulp-concat');
var del         = require('del');
var gutil       = require('gulp-util');
var fs          = require('fs');
var xml2js      = require('xml2js');
var parser      = new xml2js.Parser();
var path        = require('path');
var plumber     = require('gulp-plumber');
var rename      = require('gulp-rename');
var postcss     = require('gulp-postcss');
var purgecss    = require('gulp-purgecss');
var sass        = require('gulp-sass');
var uglify      = require('gulp-uglify');
var tailwindcss = require('tailwindcss');
var zip         = require('gulp-zip');

var tplName   = "tailwind";
var tplBase   = "site";
var tplFolder = 'tpl_' + tplName;

var baseTask  = 'templates.frontend.' + tplName;
var extPath   = '.';
var mediaPath = extPath + '/media/' + tplFolder;
var assetsPath = './media/templates/' + tplBase + '/' + tplFolder;
var nodeModulesPath = './node_modules';

var wwwPath = config.wwwDir + '/templates/' + tplName;

var templateFiles = [
	extPath + '/assets/**',
	extPath + '/html/**',
	extPath + '/language/**',
	extPath + '/bootstrap.php',
	extPath + '/favicon.ico',
	extPath + '/index.php',
	extPath + '/templateDetails.xml'
];

var onError = function (err) {
	beep([0, 0, 0]);
	gutil.log(gutil.colors.green(err));
};

// Browser sync
gulp.task('browser-sync', function() {
	return browserSync(browserConfig);
});

// Clean
gulp.task('clean',
	[
		'clean:template'
	]
);

// Clean: Template
gulp.task('clean:template', function() {
	return del(wwwPath, {force : true});
});

// Copy
gulp.task('copy',
	[
		'clean',
		'copy:template'
	],
	function() {
	});

// Copy: Template
gulp.task('copy:template', ['clean:template'], function() {
	return gulp.src(templateFiles,{ base: extPath })
		.pipe(gulp.dest(wwwPath));
});

// Override of the release script
gulp.task('release', function (cb) {
	fs.readFile(extPath + '/templateDetails.xml', function(err, data) {
		parser.parseString(data, function (err, result) {
			var version = result.extension.version[0];

			var fileName = extension.name + '-v' + version + '.zip';

			return gulp.src(templateFiles,{ base: extPath })
				.pipe(zip(fileName))
				.pipe(gulp.dest('releases'))
				.on('end', cb);
		});
	});
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
gulp.task('scripts',
	[
		'scripts:template'
	]
);

// Scripts
gulp.task('scripts:template', function () {

	return compileScripts(
		[
			assetsPath + '/js/template.js'
		],
		'scripts.js',
		'assets/js'
	);
});

class TailwindExtractor {
  static extract(content) {
    return content.match(/[A-Za-z0-9-_:\/]+/g) || [];
  }
}

function compileSassFile(src, destinationFolder, options)
{
	return gulp.src(src)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(sass())
		.pipe(postcss([
		  tailwindcss('./tailwind.js'),
		  require('autoprefixer'),
		]))
		.pipe(
		  purgecss({
			content: [
				extPath + '/html/**/*.php',
				extPath + '/index.php'
			],
	        extractors: [
	          {
	            extractor: TailwindExtractor,

	            // Specify the file extensions to include when scanning for
	            // class names.
	            extensions: ["php"]
	          }
	        ]
		  })
		)
		.pipe(cleanCSS({compatibility: 'ie8'}))
		.pipe(gulp.dest(extPath + '/' + destinationFolder))
		.pipe(gulp.dest(wwwPath + '/' + destinationFolder))
		.pipe(browserSync.reload({stream:true}))
		.pipe(rename(function (path) {
			path.basename += '.min';
		}))
		.pipe(gulp.dest(extPath + '/' + destinationFolder))
		.pipe(gulp.dest(wwwPath + '/' + destinationFolder))
		.pipe(browserSync.reload({stream:true}));
}

// Sass
gulp.task('sass', function () {
	return compileSassFile(
		assetsPath + '/scss/template.scss',
		'assets/css'
	);
});

// Watch
gulp.task('watch',
	[
		'watch:template',
		'watch:scripts',
		'watch:sass'
	],
	function() {
	});

// Watch: Template
gulp.task('watch:template', function() {
	gulp.watch([
			extPath + '/html/**',
			extPath + '/language/**',
			extPath + '/bootstrap.php',
			extPath + '/favicon.ico',
			extPath + '/index.php',
			extPath + '/templateDetails.xml'
		],
		['copy:template', 'sass', browserSync.reload]);
});

// Watch: Scripts
gulp.task('watch:scripts', function() {
	gulp.watch([
			assetsPath + '/js/**/*.js'
		],
		['scripts', browserSync.reload]);
});

// Watch: Sass
gulp.task('watch:sass', function() {
	gulp.watch([
			assetsPath + '/scss/**/*.scss'
		],
		['sass', browserSync.reload]);
});

gulp.task('default', ['copy', 'watch', 'browser-sync']);