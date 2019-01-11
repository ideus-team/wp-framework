<?php
/**
 * Styles
 * use 'get_footer' instead 'wp_enqueue_scripts' hook for move CSS to footer
 */
add_action( 'wp_enqueue_scripts', 'nc_styles' );
function nc_styles() {
  // wp_enqueue_style( 'googlefonts', '//fonts.googleapis.com/css?family=Lato:100,300,400,600,700,900|Open+Sans:300,400,600,700,800', false, null );

  if ( file_exists( get_theme_file_path( 'assets/css/main.min.css' ) ) ) {
    wp_enqueue_style( 'css-main', get_theme_file_uri( 'assets/css/main.min.css' ), false, filemtime( get_theme_file_path( 'assets/css/main.min.css' ) ) );
  }
}


/**
 * Admin styles
 */
add_action( 'admin_enqueue_scripts', 'nc_admin_styles' );
function nc_admin_styles() {
  if ( file_exists( get_theme_file_path( 'assets/css/admin.min.css' ) ) ) {
    wp_enqueue_style( 'css-admin', get_theme_file_uri( 'assets/css/admin.min.css' ), false, filemtime( get_theme_file_path( 'assets/css/admin.min.css' ) ) );
  }
}


/**
 * Login styles
 */
add_action( 'login_enqueue_scripts', 'nc_login_styles' );
function nc_login_styles() {
  if ( file_exists( get_theme_file_path( 'assets/css/login.min.css' ) ) ) {
    wp_enqueue_style( 'css-login', get_theme_file_uri( 'assets/css/login.min.css' ), false, filemtime( get_theme_file_path( 'assets/css/login.min.css' ) ) );
  }
}

