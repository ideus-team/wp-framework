<?php
/**
 * Class Hooks
 *
 * @package WP-framework
 * @since X.X.X
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\Hooks' ) ) {
  /**
   * Hooks
   *
   * @since X.X.X
   */
  class Hooks {

    /**
     * Class initialization
     *
     * @since X.X.X
     */
    public function __construct() {
      // Change text displayed after a trimmed excerpt
      add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );

      // Change the maximum number of words in a post excerpt
      add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
    }

    /**
     * Change text displayed after a trimmed excerpt
     *
     * @since X.X.X
     * @link https://developer.wordpress.org/reference/hooks/excerpt_more/
     *
     * @param  string $text Text displayed after a trimmed excerpt
     * @return string
     */
    public function excerpt_more( $text ) {
      return '…';
    }


    /**
     * Change the maximum number of words in a post excerpt
     *
     * @param  int $length Maximum number of words in a post excerpt
     * @return int
     */
    public function excerpt_length( $length ) {
      return 20;
    }

  }
}
