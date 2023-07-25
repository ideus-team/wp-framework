<?php
/**
 * Class Resources
 *
 * @package WP-framework
 * @since X.X.X
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\Resources' ) ) {
  /**
   * Resources
   *
   * @since X.X.X
   */
  class Resources {

    /**
     * Class initialization
     *
     * @since X.X.X
     */
    public function __construct() {
      // Scripts
      add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

      // Styles
      add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
      add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
      add_action( 'login_enqueue_scripts', array( $this, 'login_styles' ) );

      // Google fonts preconnect
      add_filter( 'wp_resource_hints', array( $this, 'preconnect_googlefonts' ), 10, 2 );

      // Preload fonts
      // add_action( 'wp_head', array( $this, 'preload_fonts' ), 5 );

      // Remove global styles
      add_action( 'init', array( $this, 'remove_global_css' ) );

      // Remove Gutenberg CSS
      add_action( 'wp_print_styles', array( $this, 'deregister_styles' ), 100 );
    }


    /**
     * Styles
     *
     * Use 'get_footer' instead 'wp_enqueue_scripts' hook for move CSS to footer.
     *
     * @since X.X.X
     */
    public function styles() {
      // wp_enqueue_style( 'googlefonts', 'https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&family=Open+Sans:wght@300;400;600;700;800&display=swap', false, null );

      if ( file_exists( get_theme_file_path( 'assets/css/main.min.css' ) ) ) {
        wp_enqueue_style(
          'nc-main',
          get_theme_file_uri( 'assets/css/main.min.css' ),
          false,
          filemtime( get_theme_file_path( 'assets/css/main.min.css' ) )
        );
      }
    }


    /**
     * Admin styles
     *
     * @since X.X.X
     */
    public function admin_styles() {
      if ( file_exists( get_theme_file_path( 'assets/css/admin.min.css' ) ) ) {
        wp_enqueue_style(
          'nc-admin',
          get_theme_file_uri( 'assets/css/admin.min.css' ),
          false,
          filemtime( get_theme_file_path( 'assets/css/admin.min.css' ) )
        );
      }
    }


    /**
     * Login styles
     *
     * @since X.X.X
     */
    public function login_styles() {
      if ( file_exists( get_theme_file_path( 'assets/css/login.min.css' ) ) ) {
        wp_enqueue_style(
          'nc-login',
          get_theme_file_uri( 'assets/css/login.min.css' ),
          false,
          filemtime( get_theme_file_path( 'assets/css/login.min.css' ) )
        );
      }
    }


    /**
     * Scripts
     *
     * @since X.X.X
     */
    public function scripts() {
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
       *
       * @since X.X.X
       */
      wp_localize_script( 'nc-main', 'nc_params', array(
        'ajax_url'  => admin_url( 'admin-ajax.php' ),
        'home_url'  => home_url(),
        'theme_url' => get_stylesheet_directory_uri(),
      ) );
    }


    /**
     * Google fonts preconnect
     *
     * @since X.X.X
     */
    public function preconnect_googlefonts( $urls, $relation_type ) {
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
     *
     * @since X.X.X
     */
    public function preload_fonts() {
      echo '<link rel="preload" href="' . get_theme_file_uri( 'assets/fonts/fontname.woff2' ) . '" as="font" type="font/woff2" crossorigin="anonymous">';
    }


    /**
     * Remove global styles
     *
     * @since X.X.X
     */
    public function remove_global_css() {
      remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
      remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
    }


    /**
     * Remove Gutenberg CSS
     *
     * @since X.X.X
     */
    public function deregister_styles() {
      wp_dequeue_style( 'wp-block-library' );
    }

  }
}
