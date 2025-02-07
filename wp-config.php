<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

/**
 * Current environment type.
 * Possible values are 'local', 'development', 'staging', and 'production'.
 *
 * You can change 'site.local', 'site.dev', 'site.staging' to your domain names.
 */
if ( 'site.local' === $_SERVER['SERVER_NAME'] ) {
	define( 'WP_ENVIRONMENT_TYPE', 'local' );
} elseif ( 'site.dev' === $_SERVER['SERVER_NAME'] ) {
	define( 'WP_ENVIRONMENT_TYPE', 'development' );
} elseif ( 'site.staging' === $_SERVER['SERVER_NAME'] ) {
	define( 'WP_ENVIRONMENT_TYPE', 'staging' );
} else {
	define( 'WP_ENVIRONMENT_TYPE', 'production' );
}

/**
 * Include file with MySQL and other environment settings.
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* Add any custom values between this line and the "stop editing" line. */


/**
 * Limit WordPress revisions.
 */
if ( ! defined( 'WP_POST_REVISIONS' ) ) {
	define( 'WP_POST_REVISIONS', 5 );
}


/**
 * Stop WP installing core plugins & themes.
 */
define( 'CORE_UPGRADE_SKIP_NEW_BUNDLED', true );


/**
 * Restricting access to the Contact Form 7 administration panel.
 *
 * @link https://contactform7.com/restricting-access-to-the-administration-panel/
 */
define( 'WPCF7_ADMIN_READ_CAPABILITY', 'manage_options' );
define( 'WPCF7_ADMIN_READ_WRITE_CAPABILITY', 'manage_options' );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
