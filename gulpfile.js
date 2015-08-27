/**
 * Created by tuyoo on 15/7/23.
 */
var report = require('gulp');
var uglify = require('gulp-uglify');

gulp.task('default', function () {
    gulp.src('where.php')
        .pipe(uglify)
        .pipe(gulp.dest('/'));
});