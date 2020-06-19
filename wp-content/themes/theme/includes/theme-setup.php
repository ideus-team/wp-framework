<?php
/**
 * Content Width
 * @link http://codex.wordpress.org/Content_Width
 */
if ( ! isset( $content_width ) ) {
  $content_width = 500;
}


/**
 * Theme Setup
 */
add_action( 'after_setup_theme', 'nc_setup' );
function nc_setup() {
  /**
   * Make theme available for translation.
   */
  load_theme_textdomain( 'nc_theme', get_template_directory() . '/languages' );

  remove_action( 'wp_head', 'wp_generator' );
  remove_action( 'wp_head', 'feed_links_extra', 3 );
  remove_action( 'wp_head', 'feed_links', 2 );
  remove_action( 'wp_head', 'rsd_link' );
  remove_action( 'wp_head', 'wlwmanifest_link' );
  // remove_action( 'wp_head', 'index_rel_link' );
  // remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
  // remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
  // remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
  // remove_action( 'wp_head', 'rel_canonical' );

  /**
   * This feature enables plugins and themes to manage the document title tag. This should be used in place of wp_title() function.
   */
  add_theme_support( 'title-tag' );

  /**
   * Enable RSS link
   */
  // add_theme_support( 'automatic-feed-links' );

  /**
   * This feature allows the use of HTML5 markup for the search forms, comment forms, comment lists, gallery, and caption.
   */
  add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

  /**
   * This feature enables Post Thumbnails support for a Theme.
   */
  // add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
  add_theme_support( 'post-thumbnails' );

  /**
   * This feature enables Post Formats support for a Theme.
   */
  // add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

  /**
   * Styles for editor
   */
  if ( file_exists( get_theme_file_path( 'assets/css/editor-style.min.css' ) ) ) {
    add_editor_style( 'assets/css/editor-style.min.css' );
  }

  /**
   * Navigation
   */
  register_nav_menus( array(
    'header' => 'Header Menu',
    'footer' => 'Footer Menu',
  ) );

  /**
   * WooCommerce support
   */
  // add_theme_support( 'woocommerce' );
}
