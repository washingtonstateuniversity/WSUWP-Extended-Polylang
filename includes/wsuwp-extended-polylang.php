<?php

namespace WSUWP\Polylang\Extended;

add_filter( 'pll_settings_modules', 'WSUWP\Polylang\Extended\filter_settings' );
add_filter( 'pll_settings_tabs', 'WSUWP\Polylang\Extended\filter_menu', 11 );

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
