<?php
/**
 * Class AJAX_Example
 *
 * @package WP-framework
 */

namespace iDeus\Theme;
use WP_Query;

if ( ! class_exists( 'iDeus\Theme\AJAX_Example' ) ) {
	/**
	 * AJAX request, action 'nc_example'
	 */
	class AJAX_Example {

		/**
		 * Class initialization
		 */
		public function __construct() {
			add_action( 'wp_ajax_nc_example', array( $this, 'ajax_callback' ) );
			add_action( 'wp_ajax_nopriv_nc_example', array( $this, 'ajax_callback' ) );
		}


		/**
		 * Processing AJAX request
		 */
		public function ajax_callback() {
			$result = array();

			if ( ! $_POST['postdata'] ) {
				$result['error'] = 'Empty postdata';
			} else {
				$args = wp_parse_args( $_POST['postdata'], array(
					'_wpnonce' => '',
				) );

				if ( ! wp_verify_nonce( $args['_wpnonce'] ) ) {
					$result['error'] = 'An error occurred, please refresh the page and try again';
				} else {
					$result['args'] = $args;
				}
			}

			if ( ! $result['error'] ) {
				wp_send_json_success( $result );
			} else {
				wp_send_json_error( $result );
			}
		}

	}
}
