<?php
/**
 * Class AJAX
 *
 * @package WP-framework
 * @since 2.0.0
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\AJAX' ) ) {
	/**
	 * AJAX
	 *
	 * @since 2.0.0
	 */
	class AJAX {

		/**
		 * Class initialization
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			// Include all AJAX files
			$this->include_ajax_files();

			// Example: AJAX request, action 'nc_example'
			// new \iDeus\Theme\AJAX_Example();
		}


		/**
		 * Include all AJAX files
		 *
		 * @since 2.0.0
		 */
		private function include_ajax_files() {
			foreach ( glob( get_stylesheet_directory() . '/includes/ajax/*.php' ) as $file ) {
				require_once $file;
			}
		}

	}
}
