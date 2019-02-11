<?php
/**
 * Modifiers for body
 */
add_filter( 'body_class', 'nc_body_class' );
function nc_body_class( $classes ) {
  global $post;

  if ( is_front_page() ) {
    // Homepage
    $classes[] = '-page_home';
  } else {
    $classes[] = '-page_inner';

    if ( is_404() ) {
      // Page 404
      $slug = '404';
    } elseif ( is_home() ) {
      // Posts page
      $slug = get_queried_object()->post_name;
    } elseif ( $post ) {
      // Inner Page
      $post_data = get_post( $post->ID, ARRAY_A );
      $slug = $post_data['post_name'];
    }
    $classes[] = '-page_' . $slug;
  }

  return $classes;
}
