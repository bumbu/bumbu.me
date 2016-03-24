gulp = require('gulp')
coffee = require('gulp-coffee')
livereload = require('gulp-livereload')
# CSS
stylus = require('gulp-stylus')
nib = require('nib')
csso = require('gulp-csso')
# Utils
chalk = require('chalk')
dateformat = require('dateformat')
plumber = require('gulp-plumber')
crypto = require('crypto')
fs = require('fs')
rename = require('gulp-rename')
preprocess = require('gulp-preprocess')

outputFolder = './app/wp-content/themes/bumbu'

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

gulp.task 'default', ['watch']

gulp.task 'watch', ['build'], ->
  livereload.listen({auto: true})

  # Watch style changes
  watcher_style = gulp.watch('./src/css/**/*', ['development-styles'])
  watcher_style.on 'change', (e)->
    log e.type + ' ' + chalk.yellow(filePathShort(e.path))

  # Watch script changes
  watcher_script = gulp.watch ['./src/js/**/*.coffee'], ['build-scripts']
  watcher_script.on 'change', (e)->
    log e.type + ' ' + chalk.yellow(filePathShort(e.path))

  gulp.src './src/php/*.php'
    .pipe preprocess
      context:
        cssHash: ''
    .pipe gulp.dest "#{outputFolder}/"

# Development
# #########################

gulp.task 'development-styles', ->
  gulp.src './src/css/application.styl'
    .pipe plumber()
    .pipe stylus({use: [nib()], linenos: true, 'include css': true, url: {name: 'url', limit: 32768, paths: [outputFolder + '/img']}})
    .pipe gulp.dest "#{outputFolder}/css"
    .pipe livereload auto: false

# Build
# #########################

gulp.task 'build', ['build-scripts', 'build-styles'], ->
  gulp.src './src/php/*.php'
    .pipe preprocess
      context:
        cssHash: _cssHash
    .pipe gulp.dest "#{outputFolder}/"

gulp.task 'build-scripts', ->
  # TODO append hash to file name

  gulp.src('./src/js/**/*.coffee')
    .pipe(coffee({bare: true, join: true}).on('error', log))
    .pipe(gulp.dest("#{outputFolder}/js/"))
    .pipe livereload auto: false

_cssHash = ''
gulp.task 'build-styles', ['build-styles-files', 'build-style-editor'], ->
  _cssHash = '_' + crypto.createHash('md5').update(fs.readFileSync("#{outputFolder}/css/application.css")).digest('hex').substr(0, 6)

  gulp.src "#{outputFolder}/css/application.css"
    .pipe rename
      suffix: _cssHash
    .pipe gulp.dest "#{outputFolder}/css/"

gulp.task 'build-styles-files', ->
  gulp.src './src/css/application.styl'
    .pipe stylus({use: [nib()], 'include css': true, url: {name: 'url', limit: 32768, paths: [outputFolder + '/img']}})
    .pipe(csso(false))
    .pipe gulp.dest "#{outputFolder}/css"

gulp.task 'build-style-editor', ->
  gulp.src './src/css/editor-style.styl'
    .pipe stylus({use: [nib()], 'include css': true, url: {name: 'url', limit: 32768, paths: [outputFolder + '/img']}})
    .pipe gulp.dest "#{outputFolder}"
