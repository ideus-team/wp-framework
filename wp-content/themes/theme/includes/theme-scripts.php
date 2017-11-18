<?php
/**
 * Scripts
 */
add_action( 'wp_enqueue_scripts', 'nc_scripts' );
function nc_scripts() {
  wp_register_script( 'modernizr', get_theme_file_uri( 'assets/js/vendor/modernizr-2.8.3.min.js' ), false, '2.8.3' );

  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', get_theme_file_uri( 'assets/js/vendor/jquery-3.2.1.min.js' ), false, '3.2.1' );

  wp_enqueue_script( 'js-main', get_theme_file_uri( 'assets/js/scripts.js' ), array( 'modernizr', 'jquery' ), filemtime( get_theme_file_path( 'assets/js/scripts.js' ) ), true );
  // wp_enqueue_script( 'js-extra', get_theme_file_uri( 'assets/js/scripts-extra.js' ), array( 'js-main' ), filemtime( get_theme_file_path( 'assets/js/scripts-extra.js' ) ), true );

  /**
   * Variables for JS (ncVar.ajaxurl & ncVar.themeurl)
   */
  wp_localize_script( 'js-main', 'ncVar', array(
    'ajaxurl'  => admin_url( 'admin-ajax.php' ),
    'themeurl' => get_template_directory_uri(),
  ) );
}
