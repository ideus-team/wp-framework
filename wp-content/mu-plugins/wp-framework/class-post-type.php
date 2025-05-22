<?php
/**
 * Class Post_Type.
 *
 * @package WP-framework
 */

namespace iDeus\Framework;

if ( ! class_exists( '\iDeus\Framework\Post_Type' ) ) {

	/**
	 * Post_Type class.
	 */
	class Post_Type {
		/**
		 * Class initialization.
		 *
		 * @link https://www.advancedcustomfields.com/resources/acf-settings-enable_post_types/
		 */
		public function __construct() {
			// Example.
			// add_filter( 'init', array( $this, 'post_type_example' ) );

			// Modify loops.
			// add_action( 'pre_get_posts', array( $this, 'loop_modify' ) );

			// Disable post types and taxonomies from the ACF admin.
			add_filter( 'acf/settings/enable_post_types', '__return_false' );
		}


		/**
		 * Example.
		 */
		public function post_type_example() {
			$labels = array(
				'name'               => __( 'Articles' ),
				'singular_name'      => __( 'Article' ),
				'add_new'            => __( 'Add New' ),
				'add_new_item'       => __( 'Add New Article' ),
				'edit_item'          => __( 'Edit Article' ),
				'new_item'           => __( 'New Article' ),
				'all_items'          => __( 'All Articles' ),
				'view_item'          => __( 'View Article' ),
				'parent_item_colon'  => __( 'Parent Article:' ),
				'search_items'       => __( 'Search Articles' ),
				'not_found'          => __( 'No articles found' ),
				'not_found_in_trash' => __( 'No articles found in Trash' ),
				'menu_name'          => __( 'Example' ),
			);

			$args = array(
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

			register_post_type( 'example', $args );
		}


		/**
		 * Modify loops.
		 *
		 * @param WP_Query $query The WP_Query instance (passed by reference).
		 */
		public function loop_modify( $query ) {
			if ( $query->is_main_query() && ! isset( $query->query['orderby'] ) ) {
				if ( isset( $query->query['post_type'] ) && in_array( $query->query['post_type'], array( 'post_type' ), true ) ) {
					$query->set( 'orderby', array( 'menu_order' => 'ASC' ) );
				}
			}
		}
	}

	new Post_Type();
}
