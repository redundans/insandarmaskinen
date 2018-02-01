var gulp        = require('gulp');
var browserSync = require('browser-sync').create();
var sass        = require('gulp-sass');

// Compile sass into CSS & auto-inject into browsers
gulp.task('sass', function() {
    /* gulp.src(['node_modules/open-iconic/font/css/open-iconic-bootstrap.scss'])
        .pipe(gulp.dest("src/scss"));*/
    return gulp.src(['src/scss/insandarmaskinen.scss'])
        .pipe(sass())
        .pipe(gulp.dest("dist/css"))
        .pipe(browserSync.stream());
});

// Move the assets into our /dist/assets folder
gulp.task('assets', function() {
    gulp.src(['node_modules/open-iconic/font/fonts/*'])
        .pipe(gulp.dest("src/assets/fonts"));
    return gulp.src(['src/assets/**/*'])
        .pipe(gulp.dest("dist/assets"));
});

// Move the javascript files into our /src/js folder
gulp.task('js', function() {
    gulp.src(['src/js/insandarmaskinen.js'])
        .pipe(gulp.dest("dist/js"));
    gulp.src(['node_modules/chart.js/dist/Chart.min.js'])
        .pipe(gulp.dest("dist/js"));
    gulp.src(['node_modules/taggle/dist/taggle.min.js'])
        .pipe(gulp.dest("dist/js"));
    return gulp.src(['node_modules/bootstrap/dist/js/bootstrap.min.js', 'node_modules/popper.js/dist/umd/popper.min.js'])
        .pipe(gulp.dest("dist/js"));
});

// Static Server + watching scss/html files
gulp.task('watch', ['sass', 'assets'], function() {
    gulp.watch(['node_modules/bootstrap/scss/bootstrap.scss', 'src/scss/*.scss'], ['sass']);
    gulp.watch(['src/js/*.js'], ['js']);
});

gulp.task('default', ['js','sass']);