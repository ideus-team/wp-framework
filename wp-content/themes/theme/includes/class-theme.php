<?php
/**
 * Class Theme
 *
 * @package WP-framework
 * @since X.X.X
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\Theme' ) ) {
  /**
   * Theme
   *
   * @since X.X.X
   */
  class Theme {

    /**
     * Class initialization
     *
     * @since X.X.X
     */
    public function __construct() {
      // Theme Setup
      add_action( 'after_setup_theme', array( $this, 'setup' ) );

      // JS & CSS
      new \iDeus\Theme\Resources();

      // Navigation
      new \iDeus\Theme\Navigation();

      // Custom Shorcodes
      new \iDeus\Theme\Shortcodes();

      // Hooks
      new \iDeus\Theme\Hooks();

      // SEO
      new \iDeus\Theme\SEO();

      // Branding
      new \iDeus\Theme\Branding();

      // Breadcrumbs
      new \iDeus\Theme\Breadcrumbs();

      // Advanced Custom Fields
      new \iDeus\Theme\ACF();

      // Contact Form 7
      new \iDeus\Theme\Contact_Form_7();

      // Contact Form 7
      new \iDeus\Theme\Polylang();

      // Disable important plugins deactivation
      add_filter( 'plugin_action_links', array( $this, 'disable_plugin_deactivation' ), 10, 2 );
    }


    /**
     * Theme Setup
     *
     * @since X.X.X
     */
    public function setup() {
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
      add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script' ) );

      /**
       * This feature enables Post Thumbnails support for a Theme.
       */
      // add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
      add_theme_support( 'post-thumbnails' );

      /**
       * This feature enables Post Formats support for a Theme.
       */
      // add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

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


    /**
     * Filters the action links displayed for each plugin in the Plugins list table
     *
     * @since X.X.X
     *
     * @param  string[] $actions     An array of plugin action links. By default this can include
     *                               'activate', 'deactivate', and 'delete'. With Multisite active
     *                               this can also include 'network_active' and 'network_only' items.
     * @param  string   $plugin_file Path to the plugin file relative to the plugins directory.
     * @return array
     */
    public function disable_plugin_deactivation( $actions, $plugin_file ) {
      // Important plugins
      $important_plugins = array(
        'advanced-custom-fields-pro/acf.php',
        'contact-form-7/wp-contact-form-7.php',
        'polylang/polylang.php',
        'polylang-pro/polylang.php',
      );

      // Remove action 'deactivate' from important plugins
      if ( in_array( $plugin_file, $important_plugins ) ) {
        unset( $actions['deactivate'] );
      }

      return $actions;
    }

  }
}
