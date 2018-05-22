var gulp = require('gulp'),
    assetVersion = require('gulp-asset-version')
    rename = require('gulp-rename'),
    htmlmin = require('gulp-htmlmin'),
    shell = require('gulp-shell');

// webpack
gulp.task('build', shell.task([
	'webpack'
]));

// html
gulp.task('js', function () {
    gulp.src(['dist/index.js'])
        .pipe(gulp.dest('web'));
});
gulp.task('html', function(){
    gulp.src(['dist/index.html'])
        .pipe(assetVersion({
            rootPath: 'web'
        }))
        .pipe(rename('index.php'))
        .pipe(htmlmin({
            removeComments: true,//清除HTML注释
            collapseWhitespace: true,//压缩HTML
        }))
        .pipe(gulp.dest('web'));
});


// watch
gulp.task('watch', function () {
    gulp.watch(['src/router/index.js', 'src/assets/base.scss', 'src/components/*.vue'], ['build']);
    gulp.watch(['dist/index.html', 'dist/index.js'], ['js', 'html']);
});