<?php
/*
Plugin Name: WSUWP Extended Polylang
Version: 0.0.2
Description: A WordPress plugin to apply modifications to Polylang defaults.
Author: washingtonstateuniversity, philcable
Author URI: https://web.wsu.edu/
Plugin URI: https://github.com/washingtonstateuniversity/WSUWP-Extended-Polylang
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// This plugin uses namespaces and requires PHP 5.3 or greater.
if ( version_compare( PHP_VERSION, '5.3', '<' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>' . esc_html__( 'WSUWP Extended Polylang requires PHP 5.3 to function properly. Please upgrade PHP or deactivate the plugin.', 'wsuwp-extended-polylang' ) . '</p></div>';
	} );
	return;
} else {
	include_once __DIR__ . '/includes/wsuwp-extended-polylang.php';
}
