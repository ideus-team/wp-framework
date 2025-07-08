<?php
/**
 * Class ACF.
 *
 * @package WP-framework
 * @since 2.0.0
 */

namespace iDeus\Theme;

if ( ! class_exists( '\iDeus\Theme\ACF' ) ) {
	/**
	 * Advanced Custom Fields modifications.
	 *
	 * @since 2.0.0
	 */
	class ACF {
		/**
		 * Class initialization.
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			// Update settings.
			add_action( 'acf/init', array( $this, 'update_settings' ) );

			// Options pages.
			add_action( 'acf/init', array( $this, 'options_pages' ) );

			// Custom URL validation for ACF text field with name 'url'.
			add_filter( 'acf/validate_value/name=url', array( $this, 'validate_acf_custom_url_field' ), 10, 4 );

			// Process and sanitize custom URL field value before saving.
			add_filter( 'acf/update_value/name=url', array( $this, 'process_acf_custom_url_field' ), 10, 3 );

			// Add instructions to the URL field in admin panel.
			add_filter( 'acf/load_field/name=url', array( $this, 'add_acf_url_field_instructions' ) );
		}


		/**
		 * Update ACF Settings.
		 *
		 * @since 2.0.0
		 */
		public function update_settings() {
			// Disabling ACF shortcode.
			acf_update_setting( 'enable_shortcode', false );

			// Hide the Advanced Custom Fields menu on production.
			if ( defined( 'NC_HIDE_ACF' ) && NC_HIDE_ACF && 'production' === wp_get_environment_type() ) {
				add_filter( 'acf/settings/show_admin', '__return_false' );
			}

			// Set Google Map API key.
			// acf_update_setting( 'google_api_key', NC_GOOGLE_MAP_API );
		}


		/**
		 * Options pages for ACF Pro.
		 *
		 * @since 2.0.0
		 */
		public function options_pages() {
			if ( function_exists( 'acf_add_options_page' ) ) {

				// Options pages.
				acf_add_options_page(
					array(
						'page_title' => 'Theme Options',
						'menu_title' => 'Theme Options',
						'menu_slug'  => 'nc-options-main',
						'capability' => 'manage_options',
						'redirect'   => false,
					)
				);

				/*
				// Subpage
				acf_add_options_sub_page(
					array(
						'page_title'  => 'Options subpage',
						'menu_title'  => 'Options subpage',
						'menu_slug'   => 'nc-options-subpage',
						'parent_slug' => 'nc-options-main',
						'capability'  => 'manage_options',
					)
				);

				// Multilingual options for Polylang
				foreach ( pll_languages_list() as $lang ) {
					acf_add_options_sub_page(
						array(
							'page_title'  => 'Options subpage (' . $lang . ')',
							'menu_title'  => 'Options subpage (' . $lang . ')',
							'menu_slug'   => 'nc-options-subpage-' . $lang,
							'post_id'     => 'option-' . $lang,
							'parent_slug' => 'nc-options-main',
							'capability'  => 'manage_options',
						)
					);
				}
				*/
			}
		}


		/**
		 * Custom URL validation for ACF text field with name 'url'.
		 *
		 * This function validates various URL formats including:
		 * - Relative URLs (/contact/, ./page.html, ../parent/page.html)
		 * - Email links (mailto:email@example.com)
		 * - Phone links (tel:+1234567890)
		 * - Social media and messenger links
		 * - Standard HTTP/HTTPS URLs
		 * - Anchors and query parameters
		 *
		 * @since 2.20.0
		 *
		 * @param  bool|string $valid The validation status.
		 * @param  string      $value The field value.
		 * @param  array       $field The field settings.
		 * @param  string      $input The input name.
		 * @return bool|string        True if valid, error message if invalid.
		 */
		public function validate_acf_custom_url_field( $valid, $value, $field, $input ) {
			// Allow empty values if field is not required.
			if ( empty( $value ) ) {
				return $valid;
			}

			// Sanitize the input value.
			$value = trim( $value );

			// Check again after sanitization.
			if ( empty( $value ) ) {
				return $valid;
			}

			// Define valid URL patterns.
			$valid_patterns = array(
				// Relative URLs.
				'/^\/[^\/\s].+$/',                               // /contact/, /about/us/
				'/^\.\/[^\/\s].+$/',                             // ./page.html
				'/^\.\.\/[^\/\s].+$/',                           // ../parent/page.html

				// Email links.
				'/^mailto:[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',

				// Phone links.
				'/^tel:[\+]?[\d\s\-\(\)\.]+$/',

				// SMS links
				'/^sms:[\+]?[\d\s\-\(\)\.]+$/',

				// Social media and messenger links.
				'/^whatsapp:[\+]?[\d\s\-\(\)\.]+$/',
				'/^viber:[\+]?[\d\s\-\(\)\.]+$/',
				'/^telegram:@?[a-zA-Z0-9_]+$/',
				'/^skype:[a-zA-Z0-9._-]+$/i',

				// Standard protocols.
				'/^https?:\/\/.+$/i',                            // HTTP/HTTPS
				'/^ftp:\/\/.+$/i',                               // FTP
				'/^ftps:\/\/.+$/i',                              // FTPS

				// Anchors and query parameters.
				'/^#[a-zA-Z0-9_-]+$/',                           // #section
				'/^\?.+$/',                                      // ?param=value

				// File protocols.
				'/^file:\/\/.+$/i',

				// Custom app schemes.
				'/^[a-zA-Z][a-zA-Z0-9+.-]*:.+$/',
			);

			// Check each pattern.
			foreach ( $valid_patterns as $pattern ) {
				if ( preg_match( $pattern, $value ) ) {
					return true;
				}
			}

			// Return error message if no pattern matches.
			return 'Please enter a valid URL, relative address (e.g., /contact/), email (mailto:email@example.com), or phone (tel:+1234567890).';
		}


		/**
		 * Process and sanitize custom URL field value before saving.
		 *
		 * @since 2.20.0
		 *
		 * @param  string $value   The field value.
		 * @param  int    $post_id The post ID.
		 * @param  array  $field   The field settings.
		 * @return string          Sanitized field value.
		 */
		public function process_acf_custom_url_field( $value, $post_id, $field ) {
			// Sanitize the value by trimming whitespace.
			return trim( $value );
		}


		/**
		 * Add instructions to the URL field in admin panel.
		 *
		 * @since 2.20.0
		 *
		 * @param  array $field The field settings.
		 * @return array        Modified field settings.
		 */
		public function add_acf_url_field_instructions( $field ) {
			// Only apply to text fields.
			if ( 'text' !== $field['type'] ) {
				return $field;
			}

			// Add instructions if not already set.
			if ( empty( $field['instructions'] ) ) {
				$field['instructions'] = 'Enter a full URL, relative address (/contact/), email (mailto:), or phone (tel:).';
			}

			return $field;
		}
	}
}
