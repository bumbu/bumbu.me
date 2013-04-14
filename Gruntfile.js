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
        // files: ['src/styles/*.build.less'],
        files: ['src/styles/{,*/}*.less'],
        tasks: ['less:development']
      },
      development: {
        options: {
          nospawn: true
        },
        files: [
          'app/wp-content/themes/bumbu/{,*/}*.php',
          'app/wp-content/themes/bumbu/{,*/}*.css',
          'app/wp-content/themes/bumbu/{,*/}*.js',
          'app/wp-content/themes/bumbu/{,*/}*.{png,jpg,jpeg,webp}'
        ],
        tasks: []
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
    },
    clean: {
      production: 'app/wp-content/themes/bumbu/js/{,*/}*.map'
    }
  });

  grunt.loadNpmTasks('grunt-contrib-livereload');
  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-clean');

  // Tasks definitions
  grunt.registerTask('watchWithLiveReload', [
    'livereload-start',
    'watch'
  ]);

  grunt.registerTask('server', [
    'coffee:development',
    'less:development',
    'watchWithLiveReload'
  ]);

  grunt.registerTask('test', [
  ]);

  grunt.registerTask('build', [
    'coffee:production',
    'less:production',
    'clean:production'
  ]);

  grunt.registerTask('default', [
    // 'jshint',
    'test',
    'build'
  ]);

};