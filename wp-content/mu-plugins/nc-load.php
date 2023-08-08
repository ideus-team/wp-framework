<?php
/**
 * Plugin Name: WP-framework
 * Plugin URI: https://github.com/ideus-team/wp-framework
 * Description: Functions for WP-framework
 * Author: iDeus
 * Version: 2.0.2
 * Author URI: https://ideus.biz
 */

// Cookie Change
require WPMU_PLUGIN_DIR . '/wp-framework/cookie.php';

// Modify body-class
require WPMU_PLUGIN_DIR . '/wp-framework/body-class.php';

// Alternative Walkers
require WPMU_PLUGIN_DIR . '/wp-framework/walkers.php';

// Second level menu
require WPMU_PLUGIN_DIR . '/wp-framework/submenu.php';

// Pagination
require WPMU_PLUGIN_DIR . '/wp-framework/pagination.php';

// Custom Post Types
require WPMU_PLUGIN_DIR . '/wp-framework/post-type.php';

// Custom Taxonomies
require WPMU_PLUGIN_DIR . '/wp-framework/taxonomy.php';

// Breadcrumbs
require WPMU_PLUGIN_DIR . '/wp-framework/class-breadcrumbs.php';

// Development
require WPMU_PLUGIN_DIR . '/wp-framework/development.php';

// Close from search engines indexing for dev, stage environment
require WPMU_PLUGIN_DIR . '/wp-framework/class-disable-indexing.php';
