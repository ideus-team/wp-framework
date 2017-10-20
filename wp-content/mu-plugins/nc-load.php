<?php
/*
Plugin Name: WP-framework
Plugin URI:
Description: Functions for WP-framework
Author: iDeus
Version:
Author URI: http://ideus.biz
*/

// Cookie Change
require WPMU_PLUGIN_DIR . '/nc-functions/cookie.php';

// Modify body-class
require WPMU_PLUGIN_DIR . '/nc-functions/body-class.php';

// Alternative Walkers
require WPMU_PLUGIN_DIR . '/nc-functions/walkers.php';

// Second level menu
require WPMU_PLUGIN_DIR . '/nc-functions/submenu.php';

// Pagination
require WPMU_PLUGIN_DIR . '/nc-functions/pagination.php';

// Custom Post Types
require WPMU_PLUGIN_DIR . '/nc-functions/post-type.php';

// Custom Taxonomies
require WPMU_PLUGIN_DIR . '/nc-functions/taxonomy.php';

// Breadcrumbs
require WPMU_PLUGIN_DIR . '/nc-functions/breadcrumbs.php';
