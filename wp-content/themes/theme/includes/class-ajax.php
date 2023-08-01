<?php
/**
 * Class AJAX
 *
 * @package WP-framework
 * @since X.X.X
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\AJAX' ) ) {
  /**
   * AJAX
   *
   * @since X.X.X
   */
  class AJAX {

    /**
     * Class initialization
     *
     * @since X.X.X
     */
    public function __construct() {
      // Include all AJAX files
      $this->include_ajax_files();
    }


    /**
     * Include all AJAX files
     *
     * @since X.X.X
     */
    private function include_ajax_files() {
      foreach ( glob( get_stylesheet_directory() . '/includes/ajax/*.php' ) as $file ) {
        require_once $file;
      }
    }

  }
}
