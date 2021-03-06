module.exports = function( grunt ) {
	'use strict';

	// Load all grunt tasks
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	// Project configuration
	grunt.initConfig( {
		pkg:    grunt.file.readJSON( 'package.json' ),
		concat: {
			options: {
				stripBanners: true,
				banner: '/*! <%= pkg.title %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %>\n' +
					' * <%= pkg.homepage %>\n' +
					' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
					' * Licensed GPLv2+' +
					' */\n'
			},
            main: {
                src: ['assets/js/src/plugins.js', 'assets/js/src/main.js'],
                dest: 'assets/js/main.js'
            }
		},
		jshint: {
			browser: {
				all: [
					'assets/js/src/**/*.js'
				],
				options: {
					jshintrc: '.jshintrc'
				}
			},
			grunt: {
				all: [
					'Gruntfile.js'
				],
				options: {
					jshintrc: '.gruntjshintrc'
				}
			}   
		},
		uglify: {
			all: {
				files: {
					'assets/js/main.min.js': ['assets/js/main.js']
				},
				options: {
					banner: '/*! <%= pkg.title %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %>\n' +
						' * <%= pkg.homepage %>\n' +
						' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
						' * Licensed GPLv2+' +
						' */\n',
					mangle: {
						except: ['jQuery']
					}
				}
			}
		},
		{% if ('sass' === css_type) { %}
		sass:   {
			all: {
				files: {
					'assets/css/all.css': 'assets/css/sass/theme.scss'
				}
			}
		},
		{% } else if ('less' === css_type) { %}
		less:   {
			all: {
                options : {
                    paths: './bower_components/3l/3L',
                        rootpath: './assets/',
                        relativeUrls: true
                },
				files: {
					'assets/css/all.css': 'assets/css/less/theme.less'
				}
			}
		},
		{% } %}
		cssmin: {
			options: {
				banner: '/*! <%= pkg.title %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %>\n' +
					' * <%= pkg.homepage %>\n' +
					' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
					' * Licensed GPLv2+' +
					' */\n'
			},
			minify: {
				expand: true,
				{% if ('sass' === css_type || 'less' === css_type) { %}
				cwd: 'assets/css/',
				src: ['all.css'],
				{% } else { %}
				cwd: 'assets/css/src/',
				src: ['all.css'],
				{% } %}
				dest: 'assets/css/',
				ext: '.min.css'
			}
		},
		watch:  {
			{% if ('sass' === css_type) { %}
			sass: {
				files: ['assets/css/sass/*.scss'],
				tasks: ['sass', 'cssmin'],
				options: {
					debounceDelay: 500,
                    livereload:true
				}
			},
			{% } else if ('less' === css_type) { %}
			less: {
				files: ['assets/css/less/*.less'],
				tasks: ['less', 'cssmin'],
				options: {
					debounceDelay: 500,
                    livereload:true
				}
			},
			{% } else { %}
			styles: {
				files: ['assets/css/src/*.css'],
				tasks: ['cssmin'],
				options: {
					debounceDelay: 100,
                    livereload: true
				}
			},
			{% } %}
			html: {
                files: ['*.html'],
                options: {
                    debounceDelay: 300,
                    livereload:true
                }
            },
			scripts: {
				files: ['assets/js/src/**/*.js', 'assets/js/vendor/**/*.js'],
				tasks: ['jshint', 'concat', 'uglify'],
				options: {
					debounceDelay: 100,
                    livereload: true
                }
			}
		}
	} );

	// Default task.
	{% if ('sass' === css_type) { %}
	grunt.registerTask( 'default', ['jshint', 'concat', 'uglify', 'sass', 'cssmin', 'watch'] );
	{% } else if ('less' === css_type) { %}
	grunt.registerTask( 'default', ['jshint', 'concat', 'uglify', 'less', 'cssmin', 'watch'] );
	{% } else { %}
	grunt.registerTask( 'default', ['jshint', 'concat', 'uglify', 'cssmin', 'watch'] );
	{% } %}

	grunt.util.linefeed = '\n';
};