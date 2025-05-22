<?php
/**
 * Environment color for admin bar.
 *
 * @link https://gist.github.com/renakdup/36f4a8474d0cb13ecadf0393811d5330
 *
 * @package WP-framework
 * @since 2.7.0
 */

namespace iDeus\Framework;

if ( ! class_exists( '\iDeus\Framework\Adminbar_Env_Color' ) ) {

	/**
	 * Main plugin class.
	 *
	 * @since 2.7.0
	 */
	class Adminbar_Env_Color {

		/**
		 * Class initialization.
		 *
		 * @since 2.7.0
		 */
		public function __construct() {
			add_action( 'admin_head', array( $this, 'add_admin_bar_styles' ) );
			add_action( 'wp_head', array( $this, 'add_admin_bar_styles' ) );
			add_action( 'admin_bar_menu', array( $this, 'add_admin_bar_env_item' ), 100 );
		}


		/**
		 * Add admin bar styles.
		 *
		 * @since 2.7.0
		 */
		public function add_admin_bar_styles() {
			$colors = apply_filters(
				'ideus/adminpanel_env_color/colors',
				array(
					'local'       => null, // default wp color.
					'development' => '#2271b1', // blue.
					'staging'     => '#cc6f00', // orange.
					'production'  => '#6d0d0f', // red.
				)
			);

			$current_color = $colors[ wp_get_environment_type() ];

			ob_start();
			?>

			<style>
				.nc_adminbar_env_color a {
					box-shadow: inset 0 32px 5px rgba(0, 0, 0, .5) !important;
					pointer-events: none;
				}

				<?php if ( $current_color ) : ?>

					#wpadminbar { background-color: <?php echo $current_color; ?> !important; }
					#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu { background-color: <?php echo $current_color; ?> !important; }

				<?php endif; ?>

			</style>

			<?php
			$style = ob_get_clean();

			echo $style;
		}


		/**
		 * Add environment type to admin bar.
		 *
		 * @since 2.7.0
		 *
		 * @param WP_Admin_Bar $wp_admin_bar The WP_Admin_Bar instance, passed by reference.
		 */
		public function add_admin_bar_env_item( $wp_admin_bar ) {
			$args = array(
				'id'     => 'nc_adminbar_env_color',
				'parent' => 'top-secondary',
				'title'  => 'ENV: ' . ucfirst( wp_get_environment_type() ),
				'href'   => admin_url(),
				'meta'   => array(
					'class' => 'nc_adminbar_env_color',
					'title' => __( 'Your environment' ),
				),
			);
			$wp_admin_bar->add_node( $args );
		}
	}

	new Adminbar_Env_Color();
}
