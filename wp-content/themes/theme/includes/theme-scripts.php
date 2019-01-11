<?php
/**
 * Scripts
 */
add_action( 'wp_enqueue_scripts', 'nc_scripts' );
function nc_scripts() {
  wp_register_script( 'modernizr', get_theme_file_uri( 'assets/js/vendor/modernizr-3.5.0.min.js' ), false, '3.5.0', true );

  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', get_theme_file_uri( 'assets/js/vendor/jquery-3.3.1.min.js' ), false, '3.3.1', true );

  if ( file_exists( get_theme_file_path( 'assets/js/scripts.js' ) ) ) {
    wp_enqueue_script( 'js-main', get_theme_file_uri( 'assets/js/scripts.js' ), array( 'modernizr', 'jquery' ), filemtime( get_theme_file_path( 'assets/js/scripts.js' ) ), true );
  }

  /**
   * Variables for JS (ncVar.ajaxurl & ncVar.themeurl)
   */
  wp_localize_script( 'js-main', 'ncVar', array(
    'ajaxurl'  => admin_url( 'admin-ajax.php' ),
    'themeurl' => get_template_directory_uri(),
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
