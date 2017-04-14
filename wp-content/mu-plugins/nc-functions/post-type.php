<?php
/*
// New post type for Blog
add_action( 'init', 'nc_post_blog' );
function nc_post_blog() {
  $labels = array(
    'name'               =>  __( 'Our Blog' ),
    'singular_name'      =>  __( 'Article' ),
    'add_new'            =>  __( 'Add New' ),
    'add_new_item'       =>  __( 'Add New Article' ),
    'edit_item'          =>  __( 'Edit Article' ),
    'new_item'           =>  __( 'New Article' ),
    'all_items'          =>  __( 'All Articles' ),
    'view_item'          =>  __( 'View Article' ),
    'search_items'       =>  __( 'Search Articles' ),
    'not_found'          =>  __( 'No articles found' ),
    'not_found_in_trash' =>  __( 'No articles found in Trash' ),
    'menu_name'          =>  __( 'Our Blog' ),
  );
  $args = array(
    'labels'              => $labels,
    'public'              => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'show_ui'             => true,
    'show_in_nav_menus'   => true,
    'show_in_menu'        => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => null,
    'menu_icon'           => 'dashicons-admin-post', // You can use dashicons here: https://developer.wordpress.org/resource/dashicons/
    'hierarchical'        => false,
    'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
    'taxonomies'          => array( ),
    'has_archive'         => true,
    'rewrite'             => true,
    'query_var'           => true,
  );
  register_post_type( 'blog', $args );
}
*/

// Modify loops
// add_action('pre_get_posts', 'nc_loop_modify');
function nc_loop_modify($query) {
  if ($query->is_main_query()) {
    if ($query->is_post_type_archive('post_type')) {
      $query->set('orderby', 'menu_order');
      $query->set('order', 'ASC');
    }
  }
}
