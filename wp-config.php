<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

/**
 * Current environment type
 * Possible values are 'local', 'development', 'staging', and 'production'
 */
define( 'WP_ENVIRONMENT_TYPE', 'development' );

/**
 * Include file with MySQL and other environment settings
 */
if ( file_exists( dirname( __FILE__ ) . '/wp-config.' . WP_ENVIRONMENT_TYPE . '.php' ) ) {
  include( dirname( __FILE__ ) . '/wp-config.' . WP_ENVIRONMENT_TYPE . '.php' );
}

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'put your unique phrase here' );
define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );
define( 'LOGGED_IN_KEY',    'put your unique phrase here' );
define( 'NONCE_KEY',        'put your unique phrase here' );
define( 'AUTH_SALT',        'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT',   'put your unique phrase here' );
define( 'NONCE_SALT',       'put your unique phrase here' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) && isset( $_GET['debug'] ) && 'debug' == $_GET['debug'] ) {
  define( 'WP_DEBUG', true );
}

/* Add any custom values between this line and the "stop editing" line. */


/**
 * Limit WordPress revisions
 */
if ( ! defined( 'WP_POST_REVISIONS' ) ) {
  define( 'WP_POST_REVISIONS', 5 );
}


/**
 * Contact Form 7 constants
 * @link https://contactform7.com/controlling-behavior-by-setting-constants/
 */
define( 'WPCF7_AUTOP',    false );
define( 'WPCF7_LOAD_CSS', false );


/**
 * ACF Pro License Key
 */
// define( 'ACF_PRO_LICENSE', 'yourkeyhere' );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
  define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
