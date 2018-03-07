<?php

namespace WSUWP\Polylang\Extended;

/**
 * Prevents the Lingotek class from initializing.
 *
 * @since 0.0.1
 */
define( 'PLL_LINGOTEK_AD', false );

/**
 * Disable Polylang's WPML compatibility mode.
 *
 * @since 0.0.3
 */
define( 'PLL_WPML_COMPAT', false );

add_filter( 'pll_settings_modules', 'WSUWP\Polylang\Extended\filter_settings' );
add_filter( 'pll_settings_tabs', 'WSUWP\Polylang\Extended\filter_menu', 11 );
add_filter( 'pll_predefined_flags', 'WSUWP\Polylang\Extended\filter_flags' );
add_action( 'admin_enqueue_scripts', 'WSUWP\Polylang\Extended\admin_enqueue_scripts' );
add_action( 'load-toplevel_page_mlang', 'WSUWP\Polylang\Extended\remove_about_box', 11 );
add_filter( 'pll_get_post_types', 'WSUWP\Polylang\Extended\post_types' );
add_action( 'init', 'WSUWP\Polylang\Extended\disable_media_support' );
add_filter( 'pll_get_taxonomies', 'WSUWP\Polylang\Extended\taxonomies' );

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

/**
 * Removes the About Polylang box from the "Languages" dashboard page.
 *
 * @since 0.0.1
 */
function remove_about_box() {
	remove_meta_box( 'pll-about-box', 'settings_page_mlang', 'normal' );
}

/**
 * Disables translation support for the attachment post type.
 *
 * @since 0.0.2
 *
 * @param array $post_types Post types with Polylang support.
 *
 * @return array
 */
function post_types( $post_types ) {
	unset( $post_types['attachment'] );

	return $post_types;
}

/**
 * Disables the media support option.
 *
 * @since 0.0.2
 */
function disable_media_support() {
	$polylang_options = get_option( 'polylang' );
	$polylang_options['media_support'] = false;

	update_option( 'polylang', $polylang_options );
}

/**
 * Disables translations management for University Taxonomies.
 *
 * @since 0.0.2
 *
 * @param array $taxonomies Taxonomies that can be allowed to have translation support.
 *
 * @return array
 */
function taxonomies( $taxonomies ) {
	$unset_taxonomies = array(
		'wsuwp_university_category',
		'wsuwp_university_location',
		'wsuwp_university_org',
	);

	$taxonomies = array_diff( $taxonomies, $unset_taxonomies );

	return $taxonomies;
}
