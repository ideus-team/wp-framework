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
    'home'       => 'Home',
    'paged'      => 'Page %d',
    '_404'       => 'Error 404',
    'search'     => 'Search results for "<strong>%s</strong>"',
    'author'     => 'Author archive: <strong>%s</strong>',
    'year'       => 'Archive by <strong>%d</strong> year',
    'month'      => 'Archive by: <strong>%s</strong>',
    'day'        => '',
    'attachment' => 'Media: %s',
    'tag'        => 'Posts by tag: <strong>%s</strong>',
    'tax_tag'    => '%1$s from "%2$s" by tag: <strong>%3$s</strong>',
  );

  $l10n = wp_parse_args( $l10n_new, $l10n );

  return $l10n;
}


/**
 * Breadcrumbs schema.org position
 */
add_action( 'kama_breadcrumbs', 'nc_breadcrumbs_position' );
function nc_breadcrumbs_position( $out ) {
  $breadcrumbs_old = explode( '</a>', $out );
  $count = count( $breadcrumbs_old ) - 1;

  $breadcrumbs_new = '';
  foreach ( $breadcrumbs_old as $key => $value ) {
    $breadcrumbs_new .= $value;

    if ( $key != $count ) {
      $breadcrumbs_new .= '<meta itemprop="position" content="' . $key . '"></a>';
    }
  }

  return $breadcrumbs_new;
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


/**
 * Contact Form 7 default select value
 */
// add_filter( 'wpcf7_form_elements', 'nc_wpcf7_form_elements' );
function nc_wpcf7_form_elements( $html ) {
  nc_replace_include_blank( 'interested', 'I am interested in…', $html );

  return $html;
}

function nc_replace_include_blank( $name, $text, &$html ) {
  $matches = false;
  preg_match( '/<select name="' . $name . '"[^>]*>(.*)<\/select>/iU', $html, $matches );

  if ( $matches ) {
    $select = str_replace( '<option value="">---</option>', '<option value="">' . $text . '</option>', $matches[0] );
    $html = preg_replace( '/<select name="' . $name . '"[^>]*>(.*)<\/select>/iU', $select, $html );
  }
}
