module.exports = function(grunt) {

  // Project configuration
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    coffee: {
      production: {
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

  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-contrib-less');

  // Tasks definitions
  grunt.registerTask('server', [
    'coffee'
  ]);

  grunt.registerTask('test', [
  ]);

  grunt.registerTask('build', [
    'coffee',
    'less'
  ]);

  grunt.registerTask('default', [
    // 'jshint',
    'test',
    'build'
  ]);

};