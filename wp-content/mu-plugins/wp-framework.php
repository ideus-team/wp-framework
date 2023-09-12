<?php
/**
 * Plugin Name: WP-framework
 * Plugin URI: https://github.com/ideus-team/wp-framework
 * Description: Functions for WP-framework
 * Author: iDeus
 * Version: 2.2.5
 * Author URI: https://ideus.biz
 */

// Main plugin class
require WPMU_PLUGIN_DIR . '/wp-framework/class-plugin.php';

// Walker_Nav_Menu
require WPMU_PLUGIN_DIR . '/wp-framework/class-walker-nav-menu.php';

// Breadcrumbs
require WPMU_PLUGIN_DIR . '/wp-framework/class-breadcrumbs.php';

// Close from search engines indexing for dev, stage environment
require WPMU_PLUGIN_DIR . '/wp-framework/class-disable-indexing.php';

// Pagination
require WPMU_PLUGIN_DIR . '/wp-framework/pagination.php';

// Custom Post Types
require WPMU_PLUGIN_DIR . '/wp-framework/post-type.php';

// Custom Taxonomies
require WPMU_PLUGIN_DIR . '/wp-framework/taxonomy.php';
