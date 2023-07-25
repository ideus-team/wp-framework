<?php
/**
 * Scripts
 */
add_action( 'wp_enqueue_scripts', 'nc_scripts' );
function nc_scripts() {
  wp_deregister_script( 'jquery' );
  wp_register_script(
    'jquery',
    get_theme_file_uri( 'assets/js/vendor/jquery-3.7.0.min.js' ),
    false,
    '3.7.0',
    true
  );

  if ( file_exists( get_theme_file_path( 'assets/js/scripts.js' ) ) ) {
    wp_enqueue_script(
      'nc-main',
      get_theme_file_uri( 'assets/js/scripts.js' ),
      array( 'jquery' ),
      filemtime( get_theme_file_path( 'assets/js/scripts.js' ) ),
      true
    );
  }

  /**
   * Variables for JS (nc_params.ajax_url, nc_params.home_url, nc_params.theme_url, etc.)
   */
  wp_localize_script( 'nc-main', 'nc_params', array(
    'ajax_url'  => admin_url( 'admin-ajax.php' ),
    'home_url'  => home_url(),
    'theme_url' => get_stylesheet_directory_uri(),
  ) );
}
