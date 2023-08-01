<?php
/**
 * Class Breadcrumbs
 *
 * @package WP-framework
 * @since 2.0.0
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\Breadcrumbs' ) ) {
  /**
   * Breadcrumbs modifications
   *
   * @since 2.0.0
   */
  class Breadcrumbs {

    /**
     * Class initialization
     *
     * @since 2.0.0
     */
    public function __construct() {
      // Settings
      add_filter( 'kama_breadcrumbs_default_args', array( $this, 'default_args' ) );

      // Localization
      add_filter( 'kama_breadcrumbs_default_loc', array( $this, 'default_loc' ) );

      // Position for schema.org & ld+json
      add_action( 'kama_breadcrumbs', array( $this, 'position' ), 10, 4 );

      // Example: Add link to some page after home
      // add_action( 'kama_breadcrumbs_home_after', array( $this, 'add_link_after_home' ), 10, 4 );
    }


    /**
     * Settings
     *
     * @since 2.0.0
     *
     * @param  array $args Breadcrumbs settings
     * @return array
     */
    public function default_args( $args ) {
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
     * Localization
     *
     * @since 2.0.0
     *
     * @param  array $l10n Localization strings
     * @return array
     */
    public function default_loc( $l10n ) {
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
     * Position for schema.org & ld+json
     *
     * @since 2.0.0
     *
     * @param  string $out Breadcrumbs html code
     * @param  string $sep Separator
     * @param  array  $loc Localization strings
     * @param  array  $arg Breadcrumbs settings
     * @return string
     */
    public function position( $out, $sep, $loc, $arg ) {
      if ( 'schema.org' == $arg->markup ) {
        $breadcrumbs_old = explode( '</a>', $out );
        $count = count( $breadcrumbs_old ) - 1;

        $breadcrumbs_new = '';
        foreach ( $breadcrumbs_old as $key => $value ) {
          $breadcrumbs_new .= $value;

          if ( $key != $count ) {
            $breadcrumbs_new .= '<meta itemprop="position" content="' . $key . '"></a>';
          }
        }

        $out = $breadcrumbs_new;
      } elseif ( 'ld+json' == $arg->markup ) {
        $breadcrumbs_old = explode( '"@type": "ListItem",', $out );
        $count = count( $breadcrumbs_old ) - 1;

        $breadcrumbs_new = '';
        foreach ( $breadcrumbs_old as $key => $value ) {
          $breadcrumbs_new .= $value;

          if ( $key != $count ) {
            $breadcrumbs_new .= '"@type": "ListItem", "position": ' . $key . ',';
          }
        }

        $out = $breadcrumbs_new;
      }

      return $out;
    }


    /**
     * Example: Add link to some page after home
     *
     * @since 2.0.0
     *
     * @param  string $false    Empty string by default
     * @param  string $linkpatt Link pattern
     * @param  array  $sep      Separator
     * @param  array  $ptype    Post type
     * @return string
     */
    public function add_link_after_home( $false, $linkpatt, $sep, $ptype ) {
      $post_id = 1;
      $page = get_post( $post_id );
      return sprintf( $linkpatt, get_permalink( $page ), $page->post_title ) . $sep;
    }

  }
}
