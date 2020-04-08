<?php
/**
 * Modify except
 */
function nc_excerpt( $num_words = 25, $more = '… →' ) {
  $excerpt = wp_trim_words( get_the_content(), $num_words, $more );
  echo apply_filters( 'the_excerpt', $excerpt );
}

add_filter( 'excerpt_more', 'nc_excerpt_more' );
function nc_excerpt_more( $more ) {
  return '…';
}

add_filter( 'excerpt_length', 'nc_excerpt_length' );
function nc_excerpt_length( $length ) {
  return 20;
}


/**
 * Modify nav menu objects
 */
add_filter( 'wp_nav_menu_objects', 'nc_nav_menu_objects', 10, 2 );
function nc_nav_menu_objects( $sorted_menu_items, $args ) {
  foreach ( $sorted_menu_items as $item ) {
    if ( function_exists( 'get_field' ) && get_field( '_nc_class', $item->ID ) ) {
      $item->classes[] = get_field( '_nc_class', $item->ID );
    }

    if ( function_exists( 'get_field' ) && get_field( '_nc_anchor', $item->ID ) ) {
      $anchor = '#' . get_field( '_nc_anchor', $item->ID );
      $item->url = home_url( $_SERVER['REQUEST_URI'] ) == $item->url ? $anchor : $item->url . $anchor;
      $item->classes[] = '-anchor_true';
    }
  }

  return $sorted_menu_items;
}


/**
 * Modify nav menu link attributes
 */
add_filter( 'nav_menu_link_attributes', 'nc_nav_menu_link_attributes', 10, 4 );
function nc_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
  if ( function_exists( 'get_field' ) && get_field( '_nc_modal', $item->ID ) ) {
    $atts['class'] .= ' js-modal';
  }

  return $atts;
}


/**
 * Change login header URL
 */
add_filter( 'login_headerurl', 'nc_change_login_header_url' );
function nc_change_login_header_url( $login_header_url ) {
  return home_url();
}
