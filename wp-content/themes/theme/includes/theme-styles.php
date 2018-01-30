<?php
/**
 * Styles
 */
add_action( 'wp_enqueue_scripts', 'nc_styles' );
function nc_styles() {
  $protocol = is_ssl() ? 'https' : 'http';
  // wp_enqueue_style( 'googlefonts', $protocol . '://fonts.googleapis.com/css?family=Lato:100,300,400,600,700,900|Open+Sans:300,400,600,700,800', false, null );

  wp_enqueue_style( 'css-main', get_theme_file_uri( 'assets/css/main.min.css' ), false, filemtime( get_theme_file_path( 'assets/css/main.min.css' ) ) );
}


/**
 * Admin styles
 */
add_action( 'admin_head', 'nc_admin_styles' );
function nc_admin_styles() {
  wp_enqueue_style( 'css-admin', get_theme_file_uri( 'assets/css/admin.min.css' ), false, filemtime( get_theme_file_path( 'assets/css/admin.min.css' ) ) );
}
