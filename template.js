/**
 * grunt-wp-theme
 * https://github.com/10up/grunt-wp-theme
 *
 * Copyright (c) 2013 Eric Mann, 10up
 * Licensed under the MIT License
 */

'use strict';

var exec = require("child_process").exec;

// Basic template description
exports.description = 'Create a WordPress theme.';

// Template-specific notes to be displayed before question prompts.
exports.notes = '';

// Template-specific notes to be displayed after the question prompts.
exports.after = '';

// Any existing file or directory matching this wildcard will cause a warning.
exports.warnOn = '*';

// The actual init template
exports.template = function( grunt, init, done ) {
	init.process( {}, [
		// Prompt for these values.
		init.prompt( 'title', 'WP Theme' ),
		{
			name   : 'prefix',
			message: 'PHP function prefix (alpha and underscore characters only)',
			default: 'alirta'
		},
		init.prompt( 'description', 'Wordpress Theme' ),
		init.prompt( 'homepage', 'http://alirta.com' ),
		init.prompt( 'author_name', 'Aleksey Taranets' ),
		init.prompt( 'author_email', 'markup.javascript@gmail.com' ),
		init.prompt( 'author_url', 'alirta.com' ),
		{
			name: 'css_type',
			message: 'CSS Preprocessor: Will you use "Sass", "LESS", or "none" for CSS with this project?',
			default: 'LESS'
		}
	], function( err, props ) {
		props.keywords = [];
		props.version = '0.1.0';
		props.devDependencies = {
			'grunt': '~0.4',
			'matchdep': '~0.3',
			'grunt-contrib-concat': '~0.5',
			'grunt-contrib-uglify': '~0.5',
			'grunt-contrib-cssmin': '~0.10',
			'grunt-contrib-jshint': '~0.10',
			'grunt-contrib-nodeunit': '~0.4',
			'grunt-contrib-watch': '~0.6'
		};
		
		// Sanitize names where we need to for PHP/JS
		props.name = props.title.replace( /\s+/g, '-' ).toLowerCase();
		// Development prefix (i.e. to prefix PHP function names, variables)
		props.prefix = props.prefix.replace('/[^a-z_]/i', '').toLowerCase();
		// Development prefix in all caps (e.g. for constants)
		props.prefix_caps = props.prefix.toUpperCase();
		// An additional value, safe to use as a JavaScript identifier.
		props.js_safe_name = props.name.replace(/[\W_]+/g, '_').replace(/^(\d)/, '_$1');
		// An additional value that won't conflict with NodeUnit unit tests.
		props.js_test_safe_name = props.js_safe_name === 'test' ? 'myTest' : props.js_safe_name;
		props.js_safe_name_caps = props.js_safe_name.toUpperCase();

		// Files to copy and process
		var files = init.filesToCopy( props );

		switch( props.css_type.toLowerCase()[0] ) {
			case 's':
				delete files[ 'assets/css/less/theme.less'];
				delete files[ 'assets/css/src/all.css' ];
				
				props.devDependencies["grunt-contrib-sass"] = "~0.2";
				props.css_type = 'sass';
				break;
			case 'n':
			case undefined:
				delete files[ 'assets/css/less/theme.less'];
				delete files[ 'assets/css/sass/theme.scss'];
				
				props.css_type = 'none';
				break;
			// SASS is the default
			default:
				delete files[ 'assets/css/sass/theme.scss'];
				delete files[ 'assets/css/src/all.css' ];
				
				props.devDependencies["grunt-contrib-less"] = "~0.11";
				props.css_type = 'less';
				break;
		}
		
		console.log( files );
		
		// Actually copy and process files
		init.copyAndProcess( files, props );
		
		// Generate package.json file
		init.writePackageJSON( 'package.json', props );


        exec("bower install", function(error, stdout, stderr) {
            if (error !== null) {
                console.log("Error: " + error);
            }

            // Done!
            done();
        });
	});
};