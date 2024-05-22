<?php
/**
 * Theme functions and definitions.
 *
 * @package WP-framework
 * @since 2.0.0
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No script kiddies please!' );
}


/**
 * Content Width.
 *
 * @link http://codex.wordpress.org/Content_Width
 */
if ( ! isset( $content_width ) ) {
	if ( is_admin() ) {
		$content_width = 640;
	}
}


/**
 * Theme constants & functions.
 */
require_once get_theme_file_path( 'includes/constants.php' );
require_once get_theme_file_path( 'includes/functions.php' );


/**
 * Classes.
 */
require_once get_theme_file_path( 'includes/class-theme.php' );
require_once get_theme_file_path( 'includes/class-resources.php' );
require_once get_theme_file_path( 'includes/class-navigation.php' );
require_once get_theme_file_path( 'includes/class-shortcodes.php' );
require_once get_theme_file_path( 'includes/class-hooks.php' );
require_once get_theme_file_path( 'includes/class-ajax.php' );
require_once get_theme_file_path( 'includes/class-seo.php' );
require_once get_theme_file_path( 'includes/class-branding.php' );

require_once get_theme_file_path( 'includes/class-breadcrumbs.php' );
require_once get_theme_file_path( 'includes/class-acf.php' );
require_once get_theme_file_path( 'includes/class-contact-form-7.php' );
require_once get_theme_file_path( 'includes/class-polylang.php' );


/**
 * Hide the Advanced Custom Fields menu on production.
 *
 * Set to true after production site is done.
 */
define( 'NC_HIDE_ACF', false );


/**
 * Setup Theme.
 */
new \iDeus\Theme\Theme();
