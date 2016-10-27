<?php
/*
// New taxonomy for Blog
add_action( 'init', 'nc_taxonomy_blog', 0 );
function nc_taxonomy_blog() {
  $labels = array(
    'name'              => __( 'Blog Categories' ),
    'singular_name'     => __( 'Category' ),
    'search_items'      => __( 'Search Categories' ),
    'all_items'         => __( 'All Categories' ),
    'parent_item'       => __( 'Parent Category' ),
    'parent_item_colon' => __( 'Parent Category:' ),
    'edit_item'         => __( 'Edit Category' ),
    'view_item'         => __( 'View Category' ),
    'update_item'       => __( 'Update Category' ),
    'add_new_item'      => __( 'Add New Category' ),
    'new_item_name'     => __( 'New Category Name' ),
    'menu_name'         => __( 'Categories' ),
  );
  $args = array(
    'labels'            => $labels,
    'public'            => true,
    'show_in_nav_menus' => true,
    'show_ui'           => true,
    'show_tagcloud'     => false,
    'hierarchical'      => true,
    'rewrite'           => array( 'slug' => 'blog-cat' ),
    'query_var'         => true,
  );
  register_taxonomy( 'blog-cat', 'blog', $args );
}
*/
?>
