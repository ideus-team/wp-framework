<?php
/**
 * Class Plugin
 *
 * @package WP-framework
 * @since 2.1.0
 */
namespace iDeus\Framework;

if ( ! class_exists( '\iDeus\Framework\Plugin' ) ) {

  /**
   * Main plugin class
   *
   * @since 2.1.0
   */
  class Plugin {

    /**
     * Class initialization.
     *
     * @since 2.1.0
     */
    public function __construct() {
      // Set auth cookie age
      add_filter( 'auth_cookie_expiration', array( $this, 'login_session_length' ), 10, 3 );

      // Modifiers for body
      add_filter( 'body_class', array( $this, 'body_class' ) );

      // Disable SSL verification for `wp_remote_*()` if localhost
      add_filter( 'http_request_args', array( $this, 'disable_ssl_verification' ) );
    }


    /**
     * Set auth cookie age.
     *
     * @since 2.1.0
     *
     * @param  int  $length   Duration of the expiration period in seconds.
     * @param  int  $user_id  User ID.
     * @param  bool $remember Whether to remember the user login. Default false.
     * @return int            Duration of the expiration period in seconds.
     */
    public function login_session_length( $expiration, $user_id, $remember ) {
      return YEAR_IN_SECONDS;
    }


    /**
     * Modifiers for body.
     *
     * @since 2.1.0
     *
     * @param  array $classes An array of body class names.
     * @return array
     */
    public function body_class( $classes ) {
      global $post;

      $classes[] = 'l-body';

      if ( function_exists( 'get_field' ) && get_field( '_nc_theme_style', 'option' ) ) {
        $classes[] = get_field( '_nc_theme_style', 'option' );
      }

      if ( is_front_page() ) {
        // Homepage
        $classes[] = '-page_home';
      } else {
        $classes[] = '-page_inner';

        if ( is_404() ) {
          // Page 404
          $slug = '404';
        } elseif ( is_home() && $queried_object = get_queried_object() ) {
          // Posts page
          $slug = $queried_object->post_name;
        } elseif ( is_single() || is_singular( array( 'page', 'attachment' ) ) ) {
          // Inner Page
          $post_data = get_post( $post->ID, ARRAY_A );
          $slug = $post_data['post_name'];
        }

        if ( isset( $slug ) ) {
          $classes[] = '-page_' . $slug;
        }
      }

      return $classes;
    }


    /**
     * Disable SSL verification for `wp_remote_*()` if localhost.
     *
     * @since 2.1.0
     *
     * @param  array $parsed_args An array of HTTP request arguments.
     * @return array
     */
    public function disable_ssl_verification( $parsed_args ) {
      if ( 'local' === wp_get_environment_type() ) {
        $parsed_args['sslverify'] = false;
      }

      return $parsed_args;
    }

  }

  new \iDeus\Framework\Plugin();
}
