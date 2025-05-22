<?php
/**
 * Class Contact_Form_7.
 *
 * @package WP-framework
 * @since 2.0.0
 */

namespace iDeus\Theme;

if ( ! class_exists( '\iDeus\Theme\Contact_Form_7' ) ) {
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

			// Disable 'Unsafe email config is used without sufficient protection' check.
			add_filter( 'wpcf7_config_validator_available_error_codes', array( $this, 'disable_errors_check' ), 10, 2 );
		}


		/**
		 * Disable 'Unsafe email config is used without sufficient protection' check.
		 *
		 * @since 2.9.0
		 * @link https://contactform7.com/2023/10/15/disabling-only-specific-error-types-of-config-validator/
		 */
		public function disable_errors_check( $error_codes, $contact_form ) {
			// List error codes to disable here.
			$error_codes_to_disable = array(
				'unsafe_email_without_protection',
			);

			$error_codes = array_diff( $error_codes, $error_codes_to_disable );

			return $error_codes;
		}
	}
}
