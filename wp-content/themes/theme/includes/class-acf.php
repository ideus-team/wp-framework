<?php
/**
 * Class ACF.
 *
 * @package WP-framework
 * @since 2.0.0
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\ACF' ) ) {
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
			$this->options_pages();
		}


		/**
		 * Update ACF Settings.
		 *
		 * @since 2.0.0
		 */
		public function update_settings() {
			// Disabling ACF shortcode.
			acf_update_setting( 'enable_shortcode', false );

			// Set Google Map API key.
			// acf_update_setting( 'google_api_key', NC_GOOGLE_MAP_API );
		}


		/**
		 * Options pages for ACF Pro.
		 *
		 * @since 2.0.0
		 */
		private function options_pages() {
			if ( function_exists( 'acf_add_options_page' ) ) {

				// Options pages.
				acf_add_options_page( array(
					'page_title' => 'Theme Options',
					'menu_title' => 'Theme Options',
					'menu_slug'  => 'nc-options-main',
					'capability' => 'edit_posts',
					'redirect'   => false,
				) );

				/*
				// Subpage
				acf_add_options_sub_page( array(
					'page_title'  => 'Options subpage',
					'menu_title'  => 'Options subpage',
					'menu_slug'   => 'nc-options-subpage',
					'parent_slug' => 'nc-options-main',
				) );

				// Multilingual options for Polylang
				foreach ( pll_languages_list() as $lang ) {
					acf_add_options_sub_page( array(
						'page_title'  => 'Options subpage (' . $lang . ')',
						'menu_title'  => 'Options subpage (' . $lang . ')',
						'menu_slug'   => 'nc-options-subpage-' . $lang,
						'post_id'     => 'option-' . $lang,
						'parent_slug' => 'nc-options-main',
					) );
				}
				*/
			}
		}
	}
}
