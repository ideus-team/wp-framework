<?php
/** The name of the database for WordPress */
define( 'DB_NAME', 'database_name_here' );

/** MySQL database username */
define( 'DB_USER', 'username_here' );

/** MySQL database password */
define( 'DB_PASSWORD', 'password_here' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );


/**
 * Debug
 *
 * WP_DEBUG - Enable WP_DEBUG mode
 * WP_DEBUG_DISPLAY - show debug logging on the screen
 * WP_DEBUG_LOG - write debug logging to the /wp-content/debug.log file
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'WP_DEBUG_LOG', false );


/**
 * Development mode can be set via the `WP_DEVELOPMENT_MODE` constant in `wp-config.php`.
 * Possible values are 'core', 'plugin', 'theme', 'all', or an empty string to disable
 * development mode. 'all' is a special value to signify that all three development modes
 * ('core', 'plugin', and 'theme') are enabled.
 *
 * Development mode is considered separately from `WP_DEBUG` and wp_get_environment_type().
 * It does not affect debugging output, but rather functional nuances in WordPress.
 *
 * This function retrieves the currently set development mode value. To check whether
 * a specific development mode is enabled, use wp_is_development_mode().
 */
define( 'WP_DEVELOPMENT_MODE', 'theme' );


// define( 'WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST'] );
// define( 'WP_HOME', 'https://' . $_SERVER['HTTP_HOST'] );


/**
 * SSL
 */
@ini_set( 'session.cookie_httponly', true );
@ini_set( 'session.cookie_secure', true );
@ini_set( 'session.use_only_cookies', true );


/**
 * Disable WordPress revisions
 */
define( 'WP_POST_REVISIONS', false );
