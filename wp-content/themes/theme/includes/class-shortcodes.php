<?php
/**
 * Class Shortcodes
 *
 * @package WP-framework
 * @since X.X.X
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\Shortcodes' ) ) {
  /**
   * Custom Shorcodes
   *
   * @since X.X.X
   */
  class Shortcodes {

    /**
     * Class initialization
     *
     * @since X.X.X
     */
    public function __construct() {
      // Example: Add shortcode [nc_test]
      // add_shortcode( 'nc_test', array( $this, 'nc_test' ) );
    }


    /**
     * Example: Add shortcode [nc_test]
     *
     * @since X.X.X
     *
     * @param  array  $atts    Shortcode attributes
     * @param  string $content Shortcode content
     * @return string          Returned shortcode HTML
     */
    function nc_test( $atts, $content = '' ) {
      $atts   = shortcode_atts( array(

      ), $atts );
      $output = $content;

      ob_start();
      ?>

      Test

      <?php
      $output = ob_get_clean();

      return $output;
    }

  }
}
