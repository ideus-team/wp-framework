<?php
/**
 * Include and setup Carbon Fields
 *
 * @link https://carbonfields.net/
 */
if ( file_exists( WPMU_PLUGIN_DIR . '/nc-lib/carbon-fields/carbon-fields-plugin.php' ) ) {
  require_once WPMU_PLUGIN_DIR . '/nc-lib/carbon-fields/carbon-fields-plugin.php';
}


add_action( 'carbon_register_fields', 'nc_register_custom_fields' );
function nc_register_custom_fields() {
  include_once( WPMU_PLUGIN_DIR . '/nc-functions/carbon-fields/post-meta.php' );
  include_once( WPMU_PLUGIN_DIR . '/nc-functions/carbon-fields/theme-options.php' );
  include_once( WPMU_PLUGIN_DIR . '/nc-functions/carbon-fields/term-meta.php' );
  include_once( WPMU_PLUGIN_DIR . '/nc-functions/carbon-fields/user-meta.php' );
  include_once( WPMU_PLUGIN_DIR . '/nc-functions/carbon-fields/comment-meta.php' );
  include_once( WPMU_PLUGIN_DIR . '/nc-functions/carbon-fields/nav-menu.php' );
  include_once( WPMU_PLUGIN_DIR . '/nc-functions/carbon-fields/widgets.php' );
}
