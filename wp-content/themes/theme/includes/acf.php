<?php
if ( function_exists( 'acf_add_options_page' ) ) {

  /**
   * Options pages for ACF Pro
   */
  acf_add_options_page( array(
    'page_title'  => 'Theme Options',
    'menu_title'  => 'Theme Options',
    'menu_slug'   => 'nc-options-main',
    'capability'  => 'edit_posts',
    'redirect'    => false,
  ) );

  /*
  // Subpage
  acf_add_options_sub_page( array(
    'page_title'  => 'Options subpage',
    'menu_title'  => 'Options subpage',
    'menu_slug'   => 'nc-options-subpage',
    'parent_slug' => 'nc-options-main',
  ) );

  // Multilingual options for Polylang
  foreach ( pll_languages_list() as $lang ) {
    acf_add_options_sub_page( array(
      'page_title'  => 'Options subpage (' . $lang . ')',
      'menu_title'  => 'Options subpage (' . $lang . ')',
      'menu_slug'   => 'nc-options-subpage-' . $lang,
      'post_id'     => 'option-' . $lang,
      'parent_slug' => 'nc-options-main',
    ) );
  }
  */

  /**
   * Google Maps API key for ACF Pro
   */
  // add_action( 'acf/init', 'nc_acf_init' );
  function nc_acf_init() {
    acf_update_setting( 'google_api_key', NC_GOOGLE_MAP_API );
  }


  /**
   * Styled menu element
   */
  add_filter( 'nav_menu_css_class', 'nc_change_menu_item_css_classes', 10, 4 );
  function nc_change_menu_item_css_classes( $classes, $item ) {
    $styled = get_field( '_nc_styled', $item->ID );

    if ( $styled ) {
      $classes[] = '-styled_true';
    }

    return $classes;
  }
}
