<?php
/**
 * Class Shortcodes.
 *
 * @package WP-framework
 * @since 2.0.0
 */

namespace iDeus\Theme;

if ( ! class_exists( '\iDeus\Theme\Shortcodes' ) ) {
	/**
	 * Custom Shorcodes.
	 *
	 * @since 2.0.0
	 */
	class Shortcodes {
		/**
		 * Class initialization.
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			// Example: Add shortcode [nc_test]
			// add_shortcode( 'nc_test', array( $this, 'nc_test' ) );
		}


		/**
		 * Example: Add shortcode [nc_test].
		 *
		 * @since 2.0.0
		 *
		 * @param  array  $atts    Shortcode attributes.
		 * @param  string $content Shortcode content.
		 * @return string          Returned shortcode HTML.
		 */
		public function nc_test( $atts, $content = '' ) {
			$atts   = shortcode_atts(
				array(),
				$atts
			);
			$output = $content;

			ob_start();
			?>

			Test

			<?php
			$output = ob_get_clean();

			return $output;
		}
	}
}
