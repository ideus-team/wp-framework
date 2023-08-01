<?php
/**
 * Class Branding
 *
 * @package WP-framework
 * @since X.X.X
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\Branding' ) ) {
  /**
   * Branding
   *
   * @since X.X.X
   */
  class Branding {

    /**
     * Class initialization
     *
     * @since X.X.X
     */
    public function __construct() {
      // Change login header URL from WP to site homepage
      add_filter( 'login_headerurl', array( $this, 'change_login_header_url' ) );
    }


    /**
     * Change login header URL from WP to site homepage
     *
     * @since X.X.X
     *
     * @param  string $login_header_url Login header URL
     * @return string
     */
    public function change_login_header_url( $login_header_url ) {
      return home_url();
    }

  }
}
