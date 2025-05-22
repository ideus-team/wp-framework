<?php
/**
 * Class Maintenance.
 *
 * @package WP-framework
 * @since X.X.X
 */

namespace iDeus\Framework;

if ( ! class_exists( 'Maintenance' ) ) {
	/**
	 * Maintenance mode.
	 *
	 * @since X.X.X
	 */
	class Maintenance {
		/**
		 * Class initialization.
		 *
		 * @since X.X.X
		 */
		public function __construct() {
			// Options page.
			add_action( 'acf/init', array( $this, 'options_page' ) );

			// Custom fields.
			add_action( 'acf/init', array( $this, 'custom_fields' ) );

			// Set maintenance mode.
			add_action( 'send_headers', array( $this, 'maintenance' ), 0 );

			// Add maintenance status to admin bar.
			add_action( 'admin_bar_menu', array( $this, 'add_admin_bar_env_item' ), 101 );
		}


		/**
		 * Options page.
		 *
		 * @since X.X.X
		 */
		public function options_page() {
			// Do nothing if ACF is not active.
			if ( ! function_exists( 'acf_add_options_page' ) ) {
				return false;
			}

			acf_add_options_page(
				array(
					'page_title' => 'Maintenance',
					'menu_title' => 'Maintenance',
					'menu_slug'  => 'nc-maintenance',
					'position'   => 100,
					'capability' => 'manage_options',
					'redirect'   => false,
					'icon_url'   => 'dashicons-admin-tools',
				)
			);
		}


		/**
		 * Custom fields.
		 *
		 * @since X.X.X
		 */
		public function custom_fields() {
			// Do nothing if ACF is not active.
			if ( ! function_exists( 'acf_add_local_field_group' ) ) {
				return false;
			}

			acf_add_local_field_group(
				array(
					'key'    => 'nc_group_maintenance_mode',
					'title'  => 'Maintenance Mode',
					'fields' => array(
						array(
							'key'          => 'nc_field_maintenance_mode',
							'label'        => 'Set Maintenance Mode',
							'name'         => '_nc_maintenance_mode',
							'type'         => 'true_false',
							'instructions' => 'To use a custom template, place the <code>maintenance.php</code> file in the root of your active theme.',
							'ui'           => 1,
						),
					),
					'location' => array(
						array(
							array(
								'param'    => 'options_page',
								'operator' => '==',
								'value'    => 'nc-maintenance',
							),
						),
					),
				)
			);
		}


		/**
		 * Add maintenance status to admin bar.
		 *
		 * @since X.X.X
		 *
		 * @param WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance, passed by reference.
		 */
		public function add_admin_bar_env_item( $wp_admin_bar ) {
			// Do nothing if ACF is not active.
			if ( ! function_exists( 'get_field' ) ) {
				return false;
			}

			if ( get_field( '_nc_maintenance_mode', 'option' ) ) {
				$status = 'On';
			} else {
				$status = 'Off';
			}

			$args = array(
				'id'     => 'nc_adminbar_maintenance',
				'parent' => 'top-secondary',
				'title'  => 'Maintenance Mode: ' . $status,
				'href'   => admin_url( 'admin.php?page=nc-maintenance' ),
				'meta'   => array(
					'class' => 'nc_adminbar_maintenance',
					'title' => __( 'Your environment' ),
				),
			);

			$wp_admin_bar->add_node( $args );
		}


		/**
		 * Set maintenance mode.
		 *
		 * @since X.X.X
		 */
		public function maintenance() {
			// Do nothing if ACF is not active.
			if ( ! function_exists( 'get_field' ) ) {
				return false;
			}

			if ( ! is_user_logged_in() && get_field( '_nc_maintenance_mode', 'option' ) ) {
				status_header( '503' );
				header( 'Retry-After: 7200' );
				header( 'Cache-Control: no-cache, must-revalidate, max-age=0' );

				if ( ! locate_template( 'maintenance.php' ) ) {
					wp_die(
						'<h1>The site is temporarily unavailable</h1><p>We are performing maintenance. Please check back in a little while.</p>',
						'503 Service Unavailable',
						array(
							'response'  => 503,
							'back_link' => false,
						)
					);
				} else {
					get_template_part( 'maintenance' );
				}

				exit;
			}
		}
	}

	new Maintenance();
}
