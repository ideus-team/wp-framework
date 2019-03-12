<?php
/**
 * Setup Theme
 */
require_once( get_theme_file_path( 'includes/constants.php' ) );
require_once( get_theme_file_path( 'includes/theme-setup.php' ) );
require_once( get_theme_file_path( 'includes/theme-styles.php' ) );
require_once( get_theme_file_path( 'includes/theme-scripts.php' ) );
require_once( get_theme_file_path( 'includes/theme-plugins.php' ) );

require_once( get_theme_file_path( 'includes/functions.php' ) );


/**
 * Project
 */
require_once( get_theme_file_path( 'includes/ajax.php' ) );
require_once( get_theme_file_path( 'includes/shortcodes.php' ) );
require_once( get_theme_file_path( 'includes/acf.php' ) );
// require_once( get_theme_file_path( 'includes/polylang.php' ) );
require_once( get_theme_file_path( 'includes/content-default.php' ) );
require_once( get_theme_file_path( 'includes/other.php' ) );


/**
 * Hide the Advanced Custom Fields menu
 */
// add_filter( 'acf/settings/show_admin', '__return_false' );
