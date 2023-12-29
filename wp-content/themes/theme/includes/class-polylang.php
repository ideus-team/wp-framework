<?php
/**
 * Class Polylang.
 *
 * @package WP-framework
 * @since 2.0.0
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\Polylang' ) ) {
	/**
	 * Polylang modifications.
	 *
	 * @since 2.0.0
	 */
	class Polylang {
		/**
		 * Class initialization.
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			$this->register_strings();
		}


		/**
		 * Register Polylang strings.
		 *
		 * @since 2.0.0
		 */
		private function register_strings() {
			if ( function_exists( 'pll_register_string' ) ) {
				// Example:
				// pll_register_string( $name, $string, $group, $multiline );
			}
		}
	}
}
