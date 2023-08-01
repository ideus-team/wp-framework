<?php
/**
 * Content Width
 *
 * @link http://codex.wordpress.org/Content_Width
 */
if ( ! isset( $content_width ) ) {
  if ( is_admin() ) {
    $content_width = 640;
  }
}

/**
 * Setup Theme
 */
require_once( get_theme_file_path( 'includes/constants.php' ) );
require_once( get_theme_file_path( 'includes/class-theme.php' ) );
require_once( get_theme_file_path( 'includes/class-resources.php' ) );
require_once( get_theme_file_path( 'includes/class-breadcrumbs.php' ) );
require_once( get_theme_file_path( 'includes/class-contact-form-7.php' ) );
require_once( get_theme_file_path( 'includes/class-shortcodes.php' ) );

require_once( get_theme_file_path( 'includes/functions.php' ) );


/**
 * Project
 */
require_once( get_theme_file_path( 'includes/ajax.php' ) );
require_once( get_theme_file_path( 'includes/acf.php' ) );
// require_once( get_theme_file_path( 'includes/polylang.php' ) );
require_once( get_theme_file_path( 'includes/other.php' ) );
require_once( get_theme_file_path( 'includes/class-SEO.php' ) );


/**
 * Hide the Advanced Custom Fields menu
 */
// add_filter( 'acf/settings/show_admin', '__return_false' );


/**
 * Initialize main theme class
 */
new \iDeus\Theme\Theme();
