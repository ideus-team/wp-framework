<?php
/**
 * Class Taxonomy.
 *
 * @package WP-framework
 */

namespace iDeus\Framework;

if ( ! class_exists( '\iDeus\Framework\Taxonomy' ) ) {

	/**
	 * Taxonomy class.
	 */
	class Taxonomy {
		/**
		 * Class initialization.
		 */
		public function __construct() {
			// Example.
			// add_filter( 'init', array( $this, 'taxonomy_example' ), 0 );
		}


		/**
		 * Example.
		 */
		public function taxonomy_example() {
			$labels = array(
				'name'               => __( 'Blog Categories' ),
				'singular_name'      => __( 'Category' ),
				'search_items'       => __( 'Search Categories' ),
				'all_items'          => __( 'All Categories' ),
				'view_item'          => __( 'View Category' ),
				'parent_item'        => __( 'Parent Category' ),
				'parent_item_colon'  => __( 'Parent Category:' ),
				'edit_item'          => __( 'Edit Category' ),
				'update_item'        => __( 'Update Category' ),
				'add_new_item'       => __( 'Add New Category' ),
				'new_item_name'      => __( 'New Category Name' ),
				'menu_name'          => __( 'Categories' ),
				'not_found'          => __( 'No categories found' ),
				'not_found_in_trash' => __( 'No categories found in Trash' ),
				'back_to_items'      => __( 'Back to Categories' ),
			);

			$args = array(
				'labels'             => $labels,
				'description'        => '',
				'public'             => true,
				'publicly_queryable' => true,
				'show_in_nav_menus'  => true,
				'show_ui'            => true,
				'show_tagcloud'      => false,
				'show_in_quick_edit' => true,
				'hierarchical'       => true,
				'meta_box_cb'        => 'post_categories_meta_box',
				'show_admin_column'  => true,
				'show_in_rest'       => false,
				'rewrite'            => array( 'slug' => 'example-cat' ),
				'query_var'          => true,
			);

			register_taxonomy( 'example-cat', 'example', $args );
		}
	}

	new Taxonomy();
}
