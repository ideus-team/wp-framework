<?php
/**
 * Class Hooks.
 *
 * @package WP-framework
 * @since 2.0.0
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\Hooks' ) ) {
	/**
	 * Hooks.
	 *
	 * @since 2.0.0
	 */
	class Hooks {
		/**
		 * Class initialization.
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			// Change text displayed after a trimmed excerpt.
			add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );

			// Change the maximum number of words in a post excerpt.
			add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
		}

		/**
		 * Change text displayed after a trimmed excerpt.
		 *
		 * @since 2.0.0
		 * @link https://developer.wordpress.org/reference/hooks/excerpt_more/
		 *
		 * @param  string $text Text displayed after a trimmed excerpt.
		 * @return string
		 */
		public function excerpt_more( $text ) {
			return '…';
		}


		/**
		 * Change the maximum number of words in a post excerpt.
		 *
		 * @param  int $length Maximum number of words in a post excerpt.
		 * @return int
		 */
		public function excerpt_length( $length ) {
			return 20;
		}
	}
}
