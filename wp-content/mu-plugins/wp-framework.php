<?php
/**
 * Plugin Name: WP-framework
 * Plugin URI:  https://github.com/ideus-team/wp-framework
 * Description: Functions for WP-framework
 * Author:      iDeus
 * Version:     2.14.1
 * Author URI:  https://ideus.biz
 *
 * @package WP-framework
 * @since 2.0.0
 */

// Main plugin class.
require WPMU_PLUGIN_DIR . '/wp-framework/class-plugin.php';

// Walker_Nav_Menu.
require WPMU_PLUGIN_DIR . '/wp-framework/class-walker-nav-menu.php';

// Breadcrumbs.
require WPMU_PLUGIN_DIR . '/wp-framework/class-breadcrumbs.php';

// Close from search engines indexing for dev, stage environment.
require WPMU_PLUGIN_DIR . '/wp-framework/class-disable-indexing.php';

// Environment color for admin bar.
require WPMU_PLUGIN_DIR . '/wp-framework/class-adminbar-env-color.php';

// Custom Post Types.
require WPMU_PLUGIN_DIR . '/wp-framework/class-post-type.php';

// Custom Taxonomies.
require WPMU_PLUGIN_DIR . '/wp-framework/class-taxonomy.php';

// Pagination.
require WPMU_PLUGIN_DIR . '/wp-framework/pagination.php';
