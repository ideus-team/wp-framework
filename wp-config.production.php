<?php
// ** Database settings - You can get this info from your web host ** //
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
 * Debug.
 *
 * WP_DEBUG - Enable WP_DEBUG mode.
 * WP_DEBUG_DISPLAY - show debug logging on the screen.
 * WP_DEBUG_LOG - write debug logging to the /wp-content/debug.log file.
 */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', false );


// define( 'WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST'] );
// define( 'WP_HOME', 'https://' . $_SERVER['HTTP_HOST'] );


/**
 * SSL.
 */
@ini_set( 'session.cookie_httponly', true );
@ini_set( 'session.cookie_secure', true );
@ini_set( 'session.use_only_cookies', true );
