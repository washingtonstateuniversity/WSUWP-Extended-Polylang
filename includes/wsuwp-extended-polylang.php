<?php

namespace WSUWP\Polylang\Extended;

add_filter( 'pll_settings_modules', 'WSUWP\Polylang\Extended\filter_settings' );
add_filter( 'pll_settings_tabs', 'WSUWP\Polylang\Extended\filter_menu', 11 );
add_filter( 'pll_predefined_flags', 'WSUWP\Polylang\Extended\filter_flags' );
add_action( 'admin_enqueue_scripts', 'WSUWP\Polylang\Extended\admin_enqueue_scripts' );

/**
 * Removes settings that require the pro version
 * (or could otherwise get users into trouble).
 *
 * @since 0.0.1
 *
 * @param array
 *
 * @return array
 */
function filter_settings( $modules ) {
	$unset_modules = array(
		'PLL_Settings_Media',
		'PLL_Settings_Sync',
		'PLL_Settings_WPML',
		'PLL_Settings_Share_Slug',
		'PLL_Settings_Translate_Slugs',
		'PLL_Settings_Tools',
		'PLL_Settings_Licenses',
	);

	$modules = array_diff( $modules, $unset_modules );

	return $modules;
}

/**
 * Removes the LingoTek menu item.
 *
 * @since 0.0.1
 *
 * @param array
 *
 * @return array
 */
function filter_menu( $tabs ) {
	unset( $tabs['lingotek'] );

	return $tabs;
}

/**
 * Returns an empty array for flag values.
 *
 * Although the <select> input for choosing a flag is hidden with CSS,
 * this completely removes the options, which disables the default
 * Polylang behavior of selecting a flag when a language is selected.
 *
 * @since 0.0.1
 *
 * @param array
 *
 * @return array
 */
function filter_flags( $flags ) {
	return array();
}

/**
 * Enqueues a stylesheet for hiding the flag setting and list table column
 * on the "Languages" dashboard page.
 *
 * @since 0.0.1
 *
 * @param string $hook_suffix The current admin page.
 */
function admin_enqueue_scripts( $hook_suffix ) {
	if ( 'toplevel_page_mlang' === $hook_suffix ) {
		wp_enqueue_style( 'wsuwp-polylang-extended', plugins_url( 'css/admin-languages.css', dirname( __FILE__ ) ) );
	}
}
