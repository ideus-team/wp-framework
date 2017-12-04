<?php
/**
 * Disable important plugins deactivation
 */
add_filter( 'plugin_action_links', 'nc_disable_plugin_deactivation', 10, 2 );
function nc_disable_plugin_deactivation( $actions, $plugin_file ) {
  // Remove action "edit" from all plugins
  unset( $actions['edit'] );

  // Remove action "deactivate" from important plugins
  $important_plugins = array(
    'advanced-custom-fields-pro/acf.php',
    'contact-form-7/wp-contact-form-7.php',
    'polylang/polylang.php',
    'polylang-pro/polylang.php',
  );
  if ( in_array( $plugin_file, $important_plugins ) ) {
    unset( $actions['deactivate'] );
  }

  return $actions;
}


/**
 * Breadcrumbs settings
 */
add_filter( 'kama_breadcrumbs_default_args', 'nc_breadcrumbs_default_args' );
function nc_breadcrumbs_default_args( $args ) {
  $args_new = array(
    'on_front_page'   => true,
    'show_post_title' => true,
    'show_term_title' => true,
    'title_patt'      => '<li class="b-breadcrumbs__item -state_current">%s</li>',
    'last_sep'        => true,
    'markup'          => 'schema.org',
    'priority_tax'    => array( 'category' ),
    'priority_terms'  => array(),
    'nofollow'        => false,
  );

  $args = wp_parse_args( $args_new, $args );

  return $args;
}


/**
 * Breadcrumbs localization
 */
add_filter( 'kama_breadcrumbs_default_loc', 'nc_breadcrumbs_default_loc' );
function nc_breadcrumbs_default_loc( $l10n ) {
  $l10n_new = array(
    'home'       => 'Front page',
    'paged'      => 'Page %d',
    '_404'       => 'Error 404',
    'search'     => 'Search results by query - <b>%s</b>',
    'author'     => 'Author archive: <b>%s</b>',
    'year'       => 'Archive by <b>%d</b> year',
    'month'      => 'Archive by: <b>%s</b>',
    'day'        => '',
    'attachment' => 'Media: %s',
    'tag'        => 'Posts by tag: <b>%s</b>',
    'tax_tag'    => '%1$s from "%2$s" by tag: <b>%3$s</b>',
  );

  $l10n = wp_parse_args( $l10n_new, $l10n );

  return $l10n;
}


/**
 * Breadcrumbs add link to page example
 */
// add_action( 'kama_breadcrumbs_home_after', 'nc_breadcrumbs_blog_link', 10, 4 );
function nc_breadcrumbs_blog_link( $false, $linkpatt, $sep, $ptype ) {
  $post_id = 1;
  $page = get_post( $post_id );
  return sprintf( $linkpatt, get_permalink( $page ), $page->post_title ) . $sep;
}
