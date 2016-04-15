gulp = require('gulp')
coffee = require('gulp-coffee')
uglify = require('gulp-uglify')
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
concat = require('gulp-concat')

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

gulp.task 'build', ['build-scripts', 'build-styles', 'build-highlighter'], ->
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

highlighterFolder = './node_modules/prismjs/'
highlighterFilesJs = [
  highlighterFolder + 'prism.js'
  # Langs
  highlighterFolder + 'components/prism-bash.js'
  highlighterFolder + 'components/prism-clike.js'
  highlighterFolder + 'components/prism-coffeescript.js'
  highlighterFolder + 'components/prism-c.js'
  highlighterFolder + 'components/prism-cpp.js'
  highlighterFolder + 'components/prism-css.js'
  highlighterFolder + 'components/prism-css-extras.js'
  highlighterFolder + 'components/prism-elixir.js'
  highlighterFolder + 'components/prism-git.js'
  highlighterFolder + 'components/prism-haml.js'
  highlighterFolder + 'components/prism-handlebars.js'
  highlighterFolder + 'components/prism-javascript.js'
  highlighterFolder + 'components/prism-json.js'
  highlighterFolder + 'components/prism-jsx.js'
  highlighterFolder + 'components/prism-less.js'
  highlighterFolder + 'components/prism-markdown.js'
  highlighterFolder + 'components/prism-markup.js'
  highlighterFolder + 'components/prism-php.js'
  highlighterFolder + 'components/prism-processing.js'
  highlighterFolder + 'components/prism-python.js'
  highlighterFolder + 'components/prism-ruby.js'
  highlighterFolder + 'components/prism-sass.js'
  highlighterFolder + 'components/prism-scss.js'
  highlighterFolder + 'components/prism-sql.js'
  highlighterFolder + 'components/prism-stylus.js'
  highlighterFolder + 'components/prism-swift.js'
  highlighterFolder + 'components/prism-typescript.js'
  highlighterFolder + 'components/prism-yaml.js'
  # Plugins
  highlighterFolder + 'plugins/line-highlight/prism-line-highlight.js'
  highlighterFolder + 'plugins/line-numbers/prism-line-numbers.js'
  highlighterFolder + 'plugins/autolinker/prism-autolinker.js'
  highlighterFolder + 'plugins/show-language/prism-show-language.js'
]
highlighterFilesCss = [
  highlighterFolder + 'themes/prism.css'
  # Plugins
  highlighterFolder + 'plugins/line-highlight/*.css'
  highlighterFolder + 'plugins/line-numbers/*.css'
  highlighterFolder + 'plugins/autolinker/*.css'
  highlighterFolder + 'plugins/show-language/*.css'
]

gulp.task 'build-highlighter', ['build-highlighter-js', 'build-highlighter-css']

gulp.task 'build-highlighter-js', ->
  gulp.src highlighterFilesJs
    .pipe concat('highlighter.js')
    # .pipe uglify()
    .pipe gulp.dest "#{outputFolder}/js"

gulp.task 'build-highlighter-css', ->
  gulp.src highlighterFilesCss
    .pipe concat('highlighter.css')
    .pipe(csso(false))
    .pipe gulp.dest "#{outputFolder}/css"
