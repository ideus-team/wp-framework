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
define( 'DB_CHARSET', 'utf8' );

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


define( 'WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] );
define( 'WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] );


/**
 * Disable WordPress revisions
 */
define( 'WP_POST_REVISIONS', false );
