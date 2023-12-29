<?php
/**
 * Class Contact_Form_7.
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
			// Stop loading CF7 styles.
			add_filter( 'wpcf7_load_css', '__return_false' );

			// Do not apply the 'autop' filter to the form content.
			add_filter( 'wpcf7_autop_or_not', '__return_false' );
		}
	}
}
