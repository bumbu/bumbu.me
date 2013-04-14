'use strict';

module.exports = function(grunt) {

  // Project configuration
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    watch: {
      coffee: {
        files: ['src/scripts/*.coffee'],
        tasks: ['coffee:production']
      },
      less: {
        files: ['src/styles/*.build.less'],
        tasks: ['less:development']
      },
      livereload: {
        files: [
          'app/wp-content/themes/bumbu/{,*/}*.php',
          'app/wp-content/themes/bumbu/{,*/}*.css',
          'app/wp-content/themes/bumbu/{,*/}*.js',
          'app/wp-content/themes/bumbu/{,*/}*.{png,jpg,jpeg,webp}'
        ],
        tasks: ['livereload']
      }
    },
    coffee: {
      production: {
        files: [{
          expand: true,
          cwd: 'src/scripts',
          src: '*.coffee',
          dest: 'app/wp-content/themes/bumbu/js',
          ext: '.js'
        }]
      },
      development: {
        options: {
          sourceMap: true
        },
        files: [{
          expand: true,
          cwd: 'src/scripts',
          src: '*.coffee',
          dest: 'app/wp-content/themes/bumbu/js',
          ext: '.js'
        }]
      }
    },
    less: {
      development: {
        options: {
          paths: ["src/styles"]
        },
        files: [{
          expand: true,
          cwd: 'src/styles',
          src: '*.build.less',
          dest: 'app/wp-content/themes/bumbu/css',
          ext: '.css'
        }]
      },
      production: {
        options: {
          paths: ["src/styles"],
          yuicompress: true
        },
        files: [{
          expand: true,
          cwd: 'src/styles',
          src: '*.build.less',
          dest: 'app/wp-content/themes/bumbu/css',
          ext: '.css'
        }]
      }
    }
  });

  // https://github.com/yeoman/yeoman/issues/250#issuecomment-8024212
  // https://github.com/gruntjs/grunt-contrib-connect
  // https://github.com/romainberger/yeoman-wordpress/blob/master/app/templates/Gruntfile.js
  // https://github.com/gruntjs/grunt-contrib-livereload/pull/32

  grunt.loadNpmTasks('grunt-contrib-livereload');
  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Tasks definitions
  grunt.registerTask('server', [
    'livereload-start',
    'coffee:development',
    'less:development',
    'watch'
  ]);

  grunt.registerTask('test', [
  ]);

  grunt.registerTask('build', [
    'coffee:production',
    'less:production'
  ]);

  grunt.registerTask('default', [
    // 'jshint',
    'test',
    'build'
  ]);

};