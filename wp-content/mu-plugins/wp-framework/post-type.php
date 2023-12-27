<?php
/*
// Example Post Type
add_action( 'init', function() {
	$labels = array(
		'name'               => __( 'Articles' ),
		'singular_name'      => __( 'Article' ),
		'add_new'            => __( 'Add New' ),
		'add_new_item'       => __( 'Add New Article' ),
		'edit_item'          => __( 'Edit Article' ),
		'new_item'           => __( 'New Article' ),
		'all_items'          => __( 'All Articles' ),
		'view_item'          => __( 'View Article' ),
		'parent_item_colon'  => __( 'Parent Articles:' ),
		'search_items'       => __( 'Search Articles' ),
		'not_found'          => __( 'No articles found' ),
		'not_found_in_trash' => __( 'No articles found in Trash' ),
		'menu_name'          => __( 'Our Blog' ),
	);
	$args   = array(
		'labels'              => $labels,
		'description'         => '',
		'public'              => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => false,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-admin-post', // You can use dashicons here: https://developer.wordpress.org/resource/dashicons/
		'hierarchical'        => false,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		'taxonomies'          => array(),
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	);
	register_post_type( 'blog', $args );
} );
*/


/**
 * Modify loops
 */
// add_action( 'pre_get_posts', 'nc_loop_modify' );
function nc_loop_modify( $query ) {
	if ( $query->is_main_query() ) {
		if ( isset( $query->query['post_type'] ) && in_array( $query->query['post_type'], array( 'post_type' ) ) ) {
			$query->set( 'orderby', array( 'menu_order' => 'ASC' ) );
		}
	}
}


/**
 * Disable post types and taxonomies from the ACF admin
 *
 * @link https://www.advancedcustomfields.com/resources/acf-settings-enable_post_types/
 */
add_filter( 'acf/settings/enable_post_types', '__return_false' );
