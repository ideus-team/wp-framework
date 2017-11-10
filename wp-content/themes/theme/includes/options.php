<?php
/**
 * Options pages for ACF Pro
 */
if ( function_exists( 'acf_add_options_page' ) ) {

  acf_add_options_page( array(
    'page_title'  => 'Theme Options',
    'menu_title'  => 'Theme Options',
    'menu_slug'   => 'nc-options-main',
    'capability'  => 'edit_posts',
    'redirect'    => false,
  ) );

  /*
  acf_add_options_sub_page( array(
    'page_title'  => 'Options subpage',
    'menu_title'  => 'Options subpage',
    'menu_slug'   => 'nc-options-subpage',
    'parent_slug' => 'nc-options-main',
  ) );
  */

}
