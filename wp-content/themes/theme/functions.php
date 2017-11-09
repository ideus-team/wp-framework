<?php
require_once( get_theme_file_path( 'includes/constants.php' ) );

/**
 * Content Width
 * @link http://codex.wordpress.org/Content_Width
 */
if ( ! isset( $content_width ) ) {
  $content_width = 500;
}

add_action( 'after_setup_theme', 'nc_setup' );
function nc_setup() {
  /**
   * Make theme available for translation.
   */
  load_theme_textdomain( 'nc_theme', get_template_directory() . '/languages' );

  remove_action( 'wp_head', 'wp_generator' );
  // remove_action( 'wp_head', 'feed_links_extra', 3 );
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
  add_editor_style( 'assets/css/editor-style.min.css' );

  /**
   * Navigation
   */
  register_nav_menus( array(
    'header' => 'Header Menu',
    'footer' => 'Footer Menu',
  ) );
}

/**
 * Styles
 */
add_action( 'wp_enqueue_scripts', 'nc_styles' );
function nc_styles() {
  $protocol = is_ssl() ? 'https' : 'http';
  // wp_enqueue_style( 'googlefonts', $protocol . '://fonts.googleapis.com/css?family=Lato:100,300,400,600,700,900|Open+Sans:300,400,600,700,800', false, null );

  wp_enqueue_style( 'css-main', get_theme_file_uri( 'assets/css/main.min.css' ), false, filemtime( get_theme_file_path( 'assets/css/main.min.css' ) ) );
}

/**
 * Scripts
 */
add_action( 'wp_enqueue_scripts', 'nc_scripts' );
function nc_scripts() {
  wp_register_script( 'modernizr', get_theme_file_uri( 'assets/js/vendor/modernizr-2.8.3.min.js' ), false, '2.8.3' );

  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', get_theme_file_uri( 'assets/js/vendor/jquery-3.2.1.min.js' ), false, '3.2.1' );

  wp_enqueue_script( 'js-main', get_theme_file_uri( 'assets/js/scripts.js' ), array( 'modernizr', 'jquery' ), filemtime( get_theme_file_path( 'assets/js/scripts.js' ) ), true );
  // wp_enqueue_script( 'js-extra', get_theme_file_uri( 'assets/js/scripts-extra.js' ), array( 'js-main' ), filemtime( get_theme_file_path( 'assets/js/scripts-extra.js' ) ), true );

  /**
   * Variables for JS (ncVar.ajaxurl & ncVar.themeurl)
   */
  wp_localize_script( 'js-main', 'ncVar', array(
    'ajaxurl'  => admin_url( 'admin-ajax.php' ),
    'themeurl' => get_template_directory_uri(),
  ) );
}

/**
 * Admin styles
 */
add_action('admin_head', 'nc_admin_styles');
function nc_admin_styles() {
  wp_enqueue_style( 'css-admin', get_theme_file_uri( 'assets/css/admin.min.css' ), false, filemtime( get_theme_file_path( 'assets/css/admin.min.css' ) ) );
}


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
  );
  if ( in_array( $plugin_file, $important_plugins ) ) {
    unset( $actions['deactivate'] );
  }

  return $actions;
}


/**
 * Hide the Advanced Custom Fields menu
 */
// add_filter( 'acf/settings/show_admin', '__return_false' );


/**
 * Includes
 */
require_once( get_theme_file_path( 'includes/ajax.php' ) );
require_once( get_theme_file_path( 'includes/options.php' ) );
// require_once( get_theme_file_path( 'includes/polylang.php' ) );
require_once( get_theme_file_path( 'includes/other.php' ) );
