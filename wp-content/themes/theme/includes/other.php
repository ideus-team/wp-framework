<?php
/**
 * Modify except
 */
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

      if ( function_exists( 'get_field' ) && get_field( '_nc_modal', $item->ID ) || home_url( $_SERVER['REQUEST_URI'] ) == $item->url ) {
        $item->url = $anchor;
      } else {
        $item->url = $item->url . $anchor;
      }

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


/**
 * Remove attachment pages
 */
add_action( 'wp', 'nc_remove_attachment_page' );
function nc_remove_attachment_page() {
  global $wp_query;

  if ( is_attachment() ) {
    $wp_query->set_404();
    status_header( 404 );
  }
}


/**
 * Remove author pages
 */
add_action( 'wp', 'nc_remove_author_page' );
function nc_remove_author_page() {
  global $wp_query;

  if ( is_author() ) {
    $wp_query->set_404();
    status_header( 404 );
  }
}


/**
 * Remove author pages from sitemap
 */
add_filter( 'wp_sitemaps_add_provider', 'nc_remove_author_pages_from_sitemap', 10, 2 );
function nc_remove_author_pages_from_sitemap( $provider, $name ) {
  if ( 'users' === $name ) {
    return false;
  }

  return $provider;
}
