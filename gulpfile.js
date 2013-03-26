/*
  Keep this file because gulp does not support running directly from CoffeeScript
 */

require('coffee-script/register');
var chalk = require('chalk');

// Specify, where is your Gulp config in CoffeeScript placed.
var gulpfile = 'gulpfile.coffee';
console.log('Using file', chalk.magenta(gulpfile));

// Execute CoffeeScript config.
require('./' + gulpfile);
