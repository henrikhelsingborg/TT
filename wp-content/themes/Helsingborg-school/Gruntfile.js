module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        sass: {
            options: {
                includePaths: ['bower_components/foundation/scss']
            },
            dist: {
                options: {
                    outputStyle: 'compressed'
                },
                files: {
                    'css/app.css': 'scss/app.scss'
                }
            }
        },

        copy: {
            scripts: {
                expand: true,
                cwd: 'bower_components/',
                src: '**/*.js',
                dest: 'js'
            },

            maps: {
                expand: true,
                cwd: 'bower_components/',
                src: '**/*.map',
                dest: 'js'
            }
        },

        concat: {
            dist1: {
                src: [
                    '../Helsingborg/js/modernizr/modernizr.min.js',
                    '../Helsingborg/js/foundation/js/foundation.min.js',
                    '../Helsingborg/js/foundation/js/foundation/foundation.orbit.js',
                    '../Helsingborg/js/plugins/jquery.tablesorter.min.js',
                    '../Helsingborg/js/custom/*.js',
                    'js/dev/hbg-school.dev.js'
                ],
                dest: 'js/app.js'
            },
            dist2: {
                src: [
                    '../Helsingborg/js/jquery/dist/jquery.min.js',
                    '../Helsingborg/js/jquery/dist/jquery-ui.min.js'
                ],
                dest: 'js/app.jquery.min.js'
            }
        },

        uglify: {
            dist: {
                files: {
                    '../Helsingborg/js/modernizr/modernizr.min.js': ['js/modernizr/modernizr.js'],
                    'js/app.min.js': 'js/app.js'
                }
            }
        },

        watch: {
            grunt: {
                files: ['Gruntfile.js']
            },

            sass: {
                files: 'scss/**/*.scss',
                tasks: ['sass']
            },

            concat: {
                files: 'js/**/*.js',
                tasks: ['concat']
            }
        }
    });

    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('build', ['sass', 'copy', 'uglify', 'concat:dist1', 'concat:dist2']);
    grunt.registerTask('build-sass', ['sass']);
    grunt.registerTask('default', ['copy', 'uglify', 'concat:dist1', 'concat:dist2', 'watch']);

}
