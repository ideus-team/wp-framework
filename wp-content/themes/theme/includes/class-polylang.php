<?php
/**
 * Class Polylang
 *
 * @package WP-framework
 * @since X.X.X
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\Polylang' ) ) {
  /**
   * Polylang modifications
   *
   * @since X.X.X
   */
  class Polylang {

    /**
     * Class initialization
     *
     * @since X.X.X
     */
    public function __construct() {
      $this->register_strings();
    }


    /**
     * Register Polylang strings
     *
     * @since X.X.X
     */
    private function register_strings() {
      if ( function_exists( 'pll_register_string' ) ) {
        // Example:
        // pll_register_string( $name, $string, $group, $multiline );
      }
    }

  }
}
