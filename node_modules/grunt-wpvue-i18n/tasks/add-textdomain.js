/*
 * grunt-wp-vue-i18n
 * https://github.com/sabbir1991/grunt-wp-vue-i18n
 *
 * Copyright (c) 2014 sabbir1991, LLC
 * Licensed under the MIT license.
 */

'use strict';

var wpvuei18n = require( 'wp-vue-i18n' );

module.exports = function( grunt ) {

	/**
	 * Add the text domain to gettext functions.
	 *
	 * @link http://develop.svn.wordpress.org/trunk/tools/i18n/
	 */
	grunt.registerMultiTask( 'addtextdomain', 'Add the text domain to gettext functions.', function() {
		var options,
			done = this.async(),
			files = [];

		options = this.options({
			dryRun: grunt.option( 'dry-run' ),
			textdomain: '',
			updateDomains: []
		});

		this.files.forEach(function( f ) {
			var filtered = f.src.filter(function( filepath ) {
				return grunt.file.exists( filepath );
			});

			files = files.concat( filtered );
		});

		wpvuei18n.addtextdomain( files, options )
		.catch(function( error ) {
			console.log( error );
		})
		.finally( done );
	});

};
