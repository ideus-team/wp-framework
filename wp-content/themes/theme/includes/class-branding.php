<?php
/**
 * Class Branding.
 *
 * @package WP-framework
 * @since 2.0.0
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\Branding' ) ) {
	/**
	 * Branding.
	 *
	 * @since 2.0.0
	 */
	class Branding {
		/**
		 * Class initialization.
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			// Change login header URL from WP to site homepage.
			add_filter( 'login_headerurl', array( $this, 'change_login_header_url' ) );
		}


		/**
		 * Change login header URL from WP to site homepage.
		 *
		 * @since 2.0.0
		 *
		 * @param  string $login_header_url Login header URL.
		 * @return string
		 */
		public function change_login_header_url( $login_header_url ) {
			return home_url();
		}
	}
}
