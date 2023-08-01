<?php
/**
 * Class Navigation
 *
 * @package WP-framework
 * @since X.X.X
 */

namespace iDeus\Theme;

if ( ! class_exists( 'iDeus\Theme\Navigation' ) ) {
  /**
   * Navigation modifications
   *
   * @since X.X.X
   */
  class Navigation {

    /**
     * Class initialization
     *
     * @since X.X.X
     */
    public function __construct() {
      // Styled menu item
      add_filter( 'nav_menu_css_class', array( $this, 'styled_menu_element' ), 10, 4 );
      $this->styled_menu_element_field();

      // Modify nav menu objects
      add_filter( 'wp_nav_menu_objects', array( $this, 'modify_menu_objects' ), 10, 2 );

      // Modify nav menu link attributes
      add_filter( 'nav_menu_link_attributes', array( $this, 'modify_link_attributes' ), 10, 2 );

      // Menu item label
      add_filter( 'nav_menu_item_args', array( $this, 'menu_item_label' ), 10, 3 );
    }


    /**
     * Styled menu item
     *
     * @since X.X.X
     * @link https://developer.wordpress.org/reference/hooks/nav_menu_css_class/
     *
     * @param  string[] $classes   Array of the CSS classes that are applied to the menu item's `<li>` element.
     * @param  WP_Post  $menu_item The current menu item object.
     * @return array
     */
    public function styled_menu_element( $classes, $item ) {
      if ( function_exists( 'get_field' ) && get_field( '_nc_styled', $item->ID ) ) {
        $classes[] = '-styled_true';
      }

      return $classes;
    }


    /**
     * Add field group for styled menu item
     *
     * @since X.X.X
     */
    private function styled_menu_element_field() {
      if ( function_exists( 'acf_add_local_field_group' ) ) {
        acf_add_local_field_group( array(
          'key'      => 'group_menu_item_styled',
          'title'    => 'Menu Item',
          'fields'   => array(
            array(
              'key'   => 'field_styled',
              'label' => 'Styled',
              'name'  => '_nc_styled',
              'type'  => 'true_false',
              'ui'    => 1,
            ),
          ),
          'location' => array(
            array(
              array(
                'param'    => 'nav_menu_item',
                'operator' => '==',
                'value'    => 'all',
              ),
            ),
          ),
        ) );
      }
    }


    /**
     * Modify nav menu objects
     *
     * @since X.X.X
     * @link https://developer.wordpress.org/reference/hooks/wp_nav_menu_objects/
     *
     * @param  array    $sorted_menu_items The menu items, sorted by each menu item's menu order
     * @param  stdClass $args              An object containing wp_nav_menu() arguments
     * @return array
     */
    public function modify_menu_objects( $sorted_menu_items, $args ) {
      foreach ( $sorted_menu_items as $item ) {
        if ( function_exists( 'get_field' ) && get_field( '_nc_class', $item->ID ) ) {
          $item->classes[] = get_field( '_nc_class', $item->ID );
        }

        if ( function_exists( 'get_field' ) && get_field( '_nc_anchor', $item->ID ) ) {
          $anchor = '#' . get_field( '_nc_anchor', $item->ID );

          if ( $item->url == home_url( $_SERVER['REQUEST_URI'] ) || get_field( '_nc_modal', $item->ID ) ) {
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
     *
     * @since X.X.X
     * @link https://developer.wordpress.org/reference/hooks/nav_menu_link_attributes/
     *
     * @param  array   $atts      The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored
     * @param  WP_Post $menu_item The current menu item object.
     * @return array
     */
    public function modify_link_attributes( $atts, $item ) {
      if ( function_exists( 'get_field' ) && get_field( '_nc_modal', $item->ID ) ) {
        $atts['class'] .= ' js-modal';
      }

      return $atts;
    }


    /**
     * Menu item label
     *
     * @since X.X.X
     * @link https://developer.wordpress.org/reference/hooks/nav_menu_item_args/
     *
     * @param  stdClass $args      An object of wp_nav_menu() arguments
     * @param  WP_Post  $menu_item Menu item data object
     * @param  int      $depth     Depth of menu item. Used for padding
     * @return object
     */
    public function menu_item_label( $args, $item, $depth ) {
      $label = get_field( '_nc_label', $item->ID );

      if ( $label ) {
        $args->before = $label . ' ';
      }

      return $args;
    }

  }
}
