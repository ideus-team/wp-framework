<?php
/**
 * Scripts
 */
add_action( 'wp_enqueue_scripts', 'nc_scripts' );
function nc_scripts() {
  wp_register_script( 'modernizr', get_theme_file_uri( 'assets/js/vendor/modernizr-3.11.2.min.js' ), false, '3.11.2', true );

  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', get_theme_file_uri( 'assets/js/vendor/jquery-3.5.1.min.js' ), false, '3.5.1', true );

  if ( file_exists( get_theme_file_path( 'assets/js/scripts.js' ) ) ) {
    wp_enqueue_script( 'js-main', get_theme_file_uri( 'assets/js/scripts.js' ), array( 'modernizr', 'jquery' ), filemtime( get_theme_file_path( 'assets/js/scripts.js' ) ), true );
  }

  /**
   * Variables for JS (ncVar.ajax_url, ncVar.home_url, ncVar.theme_url, etc.)
   */
  wp_localize_script( 'js-main', 'ncVar', array(
    'ajax_url'  => admin_url( 'admin-ajax.php' ),
    'home_url'  => home_url(),
    'theme_url' => get_stylesheet_directory_uri(),
  ) );
}


/**
 * Clean up script tags
 */
add_filter( 'script_loader_tag', 'nc_clean_script_tag' );
function nc_clean_script_tag( $input ) {
  $input = str_replace( ' type="text/javascript"', '', $input );
  return $input;
}
