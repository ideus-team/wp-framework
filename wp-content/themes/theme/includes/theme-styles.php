<?php
/**
 * Styles
 * use 'get_footer' instead 'wp_enqueue_scripts' hook for move CSS to footer
 */
add_action( 'wp_enqueue_scripts', 'nc_styles' );
function nc_styles() {
  // wp_enqueue_style( 'googlefonts', 'https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&family=Open+Sans:wght@300;400;600;700;800&display=swap', false, null );

  if ( file_exists( get_theme_file_path( 'assets/css/main.min.css' ) ) ) {
    wp_enqueue_style( 'nc-main', get_theme_file_uri( 'assets/css/main.min.css' ), false, filemtime( get_theme_file_path( 'assets/css/main.min.css' ) ) );
  }
}


/**
 * Admin styles
 */
add_action( 'admin_enqueue_scripts', 'nc_admin_styles' );
function nc_admin_styles() {
  if ( file_exists( get_theme_file_path( 'assets/css/admin.min.css' ) ) ) {
    wp_enqueue_style( 'nc-admin', get_theme_file_uri( 'assets/css/admin.min.css' ), false, filemtime( get_theme_file_path( 'assets/css/admin.min.css' ) ) );
  }
}


/**
 * Login styles
 */
add_action( 'login_enqueue_scripts', 'nc_login_styles' );
function nc_login_styles() {
  if ( file_exists( get_theme_file_path( 'assets/css/login.min.css' ) ) ) {
    wp_enqueue_style( 'nc-login', get_theme_file_uri( 'assets/css/login.min.css' ), false, filemtime( get_theme_file_path( 'assets/css/login.min.css' ) ) );
  }
}


/**
 * Google fonts preconnect
 */
add_filter( 'wp_resource_hints', 'nc_preconnect_googlefonts', 10, 2 );
function nc_preconnect_googlefonts( $urls, $relation_type ) {
  if ( wp_style_is( 'googlefonts' ) && 'preconnect' === $relation_type ) {
    $urls[] = 'https://fonts.googleapis.com';
    $urls[] = array(
      'href'        => 'https://fonts.gstatic.com',
      'crossorigin' => 'anonymous',
    );
  }

  return $urls;
}


/**
 * Preload fonts
 */
// add_action( 'wp_head', 'nc_preload_fonts', 5 );
function nc_preload_fonts() {
  echo '<link rel="preload" href="' . get_theme_file_uri( 'assets/fonts/fontname.woff2' ) . '" as="font" type="font/woff2" crossorigin="anonymous">';
}


/**
 * Remove global styles
 */
add_action( 'init', 'nc_remove_global_css' );
function nc_remove_global_css() {
  remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
  remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
}


/**
 * Remove Gutenberg CSS
 */
add_action( 'wp_print_styles', 'nc_deregister_styles', 100 );
function nc_deregister_styles() {
  wp_dequeue_style( 'wp-block-library' );
}
