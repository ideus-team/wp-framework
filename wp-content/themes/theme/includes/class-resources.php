<?php
/**
 * Class Resources.
 *
 * @package WP-framework
 * @since 2.0.0
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\Resources' ) ) {
	/**
	 * Resources.
	 *
	 * @since 2.0.0
	 */
	class Resources {
		/**
		 * Class initialization.
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			// Scripts.
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

			// Styles.
			add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
			add_action( 'login_enqueue_scripts', array( $this, 'login_styles' ) );

			// Google fonts preconnect.
			add_filter( 'wp_resource_hints', array( $this, 'preconnect_googlefonts' ), 10, 2 );

			// Preload fonts.
			// add_action( 'wp_head', array( $this, 'preload_fonts' ), 5 );

			// Remove global styles.
			add_action( 'init', array( $this, 'remove_global_css' ) );

			// Remove Gutenberg CSS.
			add_action( 'wp_print_styles', array( $this, 'deregister_styles' ), 100 );
		}


		/**
		 * Scripts.
		 *
		 * @since 2.0.0
		 */
		public function scripts() {
			wp_deregister_script( 'jquery' );
			wp_register_script(
				'jquery',
				get_theme_file_uri( 'assets/js/vendor/jquery-3.7.1.min.js' ),
				false,
				'3.7.0',
				true
			);

			if ( file_exists( get_theme_file_path( 'assets/js/scripts.js' ) ) ) {
				wp_enqueue_script(
					'nc-main',
					get_theme_file_uri( 'assets/js/scripts.js' ),
					array( 'jquery' ),
					filemtime( get_theme_file_path( 'assets/js/scripts.js' ) ),
					true
				);
			}

			/**
			 * Variables for JS (nc_params.ajax_url, nc_params.home_url, nc_params.theme_url, etc.).
			 *
			 * @since 2.0.0
			 */
			wp_localize_script(
				'nc-main',
				'nc_params',
				array(
					'ajax_url'  => admin_url( 'admin-ajax.php' ),
					'home_url'  => home_url(),
					'theme_url' => get_stylesheet_directory_uri(),
				)
			);
		}


		/**
		 * Styles.
		 *
		 * Use 'get_footer' instead 'wp_enqueue_scripts' hook for move CSS to footer.
		 *
		 * @since 2.0.0
		 */
		public function styles() {
			// wp_enqueue_style(
			//   'googlefonts',
			//   'https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&family=Open+Sans:wght@300;400;600;700;800&display=swap',
			//   false,
			//   null
			// );

			if ( file_exists( get_theme_file_path( 'assets/css/main.min.css' ) ) ) {
				wp_enqueue_style(
					'nc-main',
					get_theme_file_uri( 'assets/css/main.min.css' ),
					false,
					filemtime( get_theme_file_path( 'assets/css/main.min.css' ) )
				);
			}
		}


		/**
		 * Admin styles.
		 *
		 * @since 2.0.0
		 */
		public function admin_styles() {
			if ( file_exists( get_theme_file_path( 'assets/css/admin.min.css' ) ) ) {
				wp_enqueue_style(
					'nc-admin',
					get_theme_file_uri( 'assets/css/admin.min.css' ),
					false,
					filemtime( get_theme_file_path( 'assets/css/admin.min.css' ) )
				);
			}
		}


		/**
		 * Login styles.
		 *
		 * @since 2.0.0
		 */
		public function login_styles() {
			if ( file_exists( get_theme_file_path( 'assets/css/login.min.css' ) ) ) {
				wp_enqueue_style(
					'nc-login',
					get_theme_file_uri( 'assets/css/login.min.css' ),
					false,
					filemtime( get_theme_file_path( 'assets/css/login.min.css' ) )
				);
			}
		}


		/**
		 * Google fonts preconnect.
		 *
		 * @since 2.0.0
		 *
		 * @param array  $urls          Array of resources and their attributes, or URLs to print for resource hints.
		 * @param string $relation_type The relation type the URLs are printed for, e.g. 'preconnect' or 'prerender'.
		 */
		public function preconnect_googlefonts( $urls, $relation_type ) {
			if ( wp_style_is( 'googlefonts' ) && 'preconnect' === $relation_type ) {
				$urls[] = 'https://fonts.googleapis.com';
				$urls[] = array(
					'href'        => 'https://fonts.gstatic.com',
					'crossorigin' => 'anonymous',
				);
			}

			return $urls;
		}


		/**
		 * Preload fonts.
		 *
		 * @since 2.0.0
		 */
		public function preload_fonts() {
			echo '<link rel="preload" href="' . esc_url( get_theme_file_uri( 'assets/fonts/fontname.woff2' ) ) . '" as="font" type="font/woff2" crossorigin="anonymous">';
		}


		/**
		 * Remove global styles.
		 *
		 * @since 2.0.0
		 */
		public function remove_global_css() {
			remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
			remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
		}


		/**
		 * Remove Gutenberg CSS.
		 *
		 * @since 2.0.0
		 */
		public function deregister_styles() {
			wp_dequeue_style( 'wp-block-library' );
		}
	}
}
