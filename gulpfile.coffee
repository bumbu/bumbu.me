gulp = require('gulp')
less = require('gulp-less')
coffee = require('gulp-coffee')
livereload = require('gulp-livereload')
chalk = require('chalk')
dateformat = require('dateformat')

outputFolder = './app/wp-content/themes/bumbu/'

log = ->
  time = '[' + chalk.magenta(dateformat(new Date(), 'HH:MM:ss')) + ']'
  args = Array::slice.call(arguments)
  args.unshift time
  console.log.apply console, args
  return this

filePathShort = (filePath)->
  filePath.replace(__dirname, '')

# Watch
# #########################

gulp.task 'watch', ['build'], ->
  livereload.listen({auto: true})

  # Watch style changes
  watcher_style = gulp.watch('./src/css/**/*', ['build-styles'])
  watcher_style.on 'change', (e)->
    log e.type + ' ' + chalk.yellow(filePathShort(e.path))

  # Watch script changes
  watcher_script = gulp.watch ['./src/js/**/*.coffee'], ['build-scripts']
  watcher_script.on 'change', (e)->
    log e.type + ' ' + chalk.yellow(filePathShort(e.path))

# Build
# #########################

gulp.task 'build', ['build-scripts', 'build-styles'], ->
  1

gulp.task 'build-scripts', ->
  # TODO append hash to file name

  gulp.src('./src/js/**/*.coffee')
    .pipe(coffee({bare: true, join: true}).on('error', log))
    .pipe(gulp.dest("#{outputFolder}js/"))
    .pipe livereload auto: false

gulp.task 'build-styles', ['build-styles-files'], ->
  1 # TODO append hash to file name

gulp.task 'build-styles-files', ->
  gulp.src('./src/css/application.less')
    .pipe(less())
    .pipe(gulp.dest("#{outputFolder}css/"))
    .pipe livereload auto: false
