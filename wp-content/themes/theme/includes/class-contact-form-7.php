<?php
/**
 * Class Contact_Form_7
 *
 * @package WP-framework
 * @since 2.0.0
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\Contact_Form_7' ) ) {
  /**
   * Contact Form 7 modifications.
   *
   * @since 2.0.0
   */
  class Contact_Form_7 {

    /**
     * Class initialization.
     *
     * @since 2.0.0
     */
    public function __construct() {
      // Stop loading CF7 styles
      add_filter( 'wpcf7_load_css', '__return_false' );

      // Do not apply the 'autop' filter to the form content
      add_filter( 'wpcf7_autop_or_not', '__return_false' );

      // Set default empty option for select
      // add_filter( 'wpcf7_form_elements', array( $this, 'select_empty_option' ) );
    }


    /**
     * Set default empty option for select.
     *
     * @since 2.0.2
     *
     * @param  string $html Form HTML
     * @return string
     */
    public function select_empty_option( $html ) {
      $this->replace_include_blank( 'location', 'Select One', $html );

      return $html;
    }


    /**
     * Replace empty option with custom.
     *
     * @since 2.0.2
     *
     * @param  string $name  Select name
     * @param  string $text  Select text
     * @param  string $html  Form HTML
     * @return string        Form HTML
     */
    private function replace_include_blank( $name, $text, $html ) {
      $matches = false;
      preg_match( '/<select name="' . $name . '"[^>]*>(.*)<\/select>/iU', $html, $matches );

      if ( $matches ) {
        $select = str_replace( '<option value="">---</option>', '<option value="">' . $text . '</option>', $matches[0] );
        $html = preg_replace( '/<select name="' . $name . '"[^>]*>(.*)<\/select>/iU', $select, $html );
      }

      return $html;
    }

  }
}
