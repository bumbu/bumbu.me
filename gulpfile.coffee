gulp = require('gulp')
less = require('gulp-less')
coffee = require('gulp-coffee')
chalk = require('chalk')

outputFolder = './app/wp-content/themes/bumbu/'

log = ->
  time = '[' + chalk.magenta(dateformat(new Date(), 'HH:MM:ss')) + ']'
  args = Array::slice.call(arguments)
  args.unshift time
  console.log.apply console, args
  return this

# Watch
# #########################

gulp.task 'watch', ->
  1 # TODO watch files and compile them on changes

# Build
# #########################

gulp.task 'build', ['build-scripts', 'build-styles'], ->
  1

gulp.task 'build-scripts', ->
  # TODO append hash to file name

  gulp.src('./src/js/**/*.coffee')
    .pipe(coffee({bare: true, join: true}).on('error', log))
    .pipe(gulp.dest("#{outputFolder}js/"))

gulp.task 'build-styles', ['build-styles-files'], ->
  1 # TODO append hash to file name

gulp.task 'build-styles-files', ->
  gulp.src('./src/css/application.less')
    .pipe(less())
    .pipe(gulp.dest("#{outputFolder}css/"))
