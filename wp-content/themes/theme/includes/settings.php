<?php
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
