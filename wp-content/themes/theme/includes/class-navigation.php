<?php
/**
 * Class Navigation.
 *
 * @package WP-framework
 * @since 2.0.0
 */

namespace iDeus\Theme;

if ( ! class_exists( '\iDeus\Theme\Navigation' ) ) {
	/**
	 * Navigation modifications.
	 *
	 * @since 2.0.0
	 */
	class Navigation {
		/**
		 * Class initialization.
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			// Get submenu items from a WordPress menu based on parent or sibling.
			add_filter( 'wp_nav_menu_objects', array( $this, 'sub_menu' ), 10, 2 );

			// Add field group for menu item.
			$this->menu_element_fields();

			// Styled menu item.
			add_filter( 'nav_menu_css_class', array( $this, 'styled_menu_element' ), 10, 4 );

			// Modify nav menu objects.
			add_filter( 'wp_nav_menu_objects', array( $this, 'modify_menu_objects' ), 10, 2 );

			// Modify nav menu link attributes.
			add_filter( 'nav_menu_link_attributes', array( $this, 'modify_link_attributes' ), 10, 2 );

			// Menu item label.
			add_filter( 'nav_menu_item_args', array( $this, 'menu_item_label' ), 10, 3 );
		}


		/**
		 * Get submenu items from a WordPress menu based on parent or sibling.
		 *
		 * React on wp_nav_menu flags: sub_menu, direct_parent, show_parent
		 * Example:
		 * wp_nav_menu( array(
		 *   'menu'          => 'Menu Name',
		 *   'sub_menu'      => true,
		 *   'direct_parent' => true,
		 *   'show_parent'   => true,
		 * ) );
		 *
		 * @since 2.1.0
		 * @link https://christianvarga.com/how-to-get-submenu-items-from-a-wordpress-menu-based-on-parent-or-sibling/
		 *
		 * @param  array    $sorted_menu_items The menu items, sorted by each menu item's menu order.
		 * @param  stdClass $args              An object containing wp_nav_menu() arguments.
		 * @return array
		 */
		public function sub_menu( $sorted_menu_items, $args ) {
			if ( ! empty( $args->sub_menu ) ) {
				$root_id = 0;

				// Find the current menu item.
				foreach ( $sorted_menu_items as $menu_item ) {
					if ( $menu_item->current ) {
						// Set the root id based on whether the current menu item has a parent or not.
						$root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
						break;
					}
				}

				// Find the top level parent.
				if ( empty( $args->direct_parent ) ) {
					$prev_root_id = $root_id;
					while ( 0 !== $prev_root_id ) {
						foreach ( $sorted_menu_items as $menu_item ) {
							if ( $prev_root_id === $menu_item->ID ) {
								$prev_root_id = $menu_item->menu_item_parent;
								// Don't set the root_id to 0 if we've reached the top of the menu.
								if ( 0 !== $prev_root_id ) {
									$root_id = $menu_item->menu_item_parent;
								}
								break;
							}
						}
					}
				}

				$menu_item_parents = array();
				foreach ( $sorted_menu_items as $key => $item ) {
					// Init menu_item_parents.
					if ( $root_id === $item->ID ) {
						$menu_item_parents[] = $item->ID;
					}

					if ( in_array( $item->menu_item_parent, $menu_item_parents, true ) ) {
						// Part of sub-tree: keep!
						$menu_item_parents[] = $item->ID;
					} elseif ( ! ( ! empty( $args->show_parent ) && in_array( $item->ID, $menu_item_parents, true ) ) ) {
						// Not part of sub-tree: away with it!
						unset( $sorted_menu_items[ $key ] );
					}
				}

				return $sorted_menu_items;
			} else {
				return $sorted_menu_items;
			}
		}


		/**
		 * Styled menu item.
		 *
		 * @since 2.0.0
		 * @link https://developer.wordpress.org/reference/hooks/nav_menu_css_class/
		 *
		 * @param  string[] $classes   Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param  WP_Post  $menu_item The current menu item object.
		 * @return array
		 */
		public function styled_menu_element( $classes, $menu_item ) {
			// Do nothing if ACF is not active.
			if ( ! function_exists( 'get_field' ) ) {
				return $classes;
			}

			if ( get_field( '_nc_styled', $menu_item->ID ) ) {
				$classes[] = '-styled_true';
			}

			return $classes;
		}


		/**
		 * Add field group for menu item.
		 *
		 * @since 2.0.0
		 */
		private function menu_element_fields() {
			if ( function_exists( 'acf_add_local_field_group' ) ) {
				acf_add_local_field_group(
					array(
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
							array(
								'key'     => 'field_anchor',
								'label'   => 'Anchor',
								'name'    => '_nc_anchor',
								'type'    => 'text',
								'prepend' => '#',
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
					)
				);
			}
		}


		/**
		 * Modify nav menu objects.
		 *
		 * @since 2.0.0
		 * @link https://developer.wordpress.org/reference/hooks/wp_nav_menu_objects/
		 *
		 * @param  array    $sorted_menu_items The menu items, sorted by each menu item's menu order.
		 * @param  stdClass $args              An object containing wp_nav_menu() arguments.
		 * @return array
		 */
		public function modify_menu_objects( $sorted_menu_items, $args ) {
			// Do nothing if ACF is not active.
			if ( ! function_exists( 'get_field' ) ) {
				return $sorted_menu_items;
			}

			foreach ( $sorted_menu_items as $item ) {
				if ( get_field( '_nc_class', $item->ID ) ) {
					$item->classes[] = get_field( '_nc_class', $item->ID );
				}

				// Link anchor.
				if ( get_field( '_nc_anchor', $item->ID ) ) {
					$anchor = '#' . get_field( '_nc_anchor', $item->ID );

					if ( isset( $_SERVER['REQUEST_URI'] ) && home_url( $_SERVER['REQUEST_URI'] ) === $item->url || get_field( '_nc_modal', $item->ID ) ) {
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
		 * Modify nav menu link attributes.
		 *
		 * @since 2.0.0
		 * @link https://developer.wordpress.org/reference/hooks/nav_menu_link_attributes/
		 *
		 * @param  array   $atts      The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 * @param  WP_Post $menu_item The current menu item object.
		 * @return array
		 */
		public function modify_link_attributes( $atts, $menu_item ) {
			// Do nothing if ACF is not active.
			if ( ! function_exists( 'get_field' ) ) {
				return $atts;
			}

			if ( get_field( '_nc_modal', $menu_item->ID ) ) {
				$atts['class'] .= ' js-modal';
			}

			return $atts;
		}


		/**
		 * Menu item label.
		 *
		 * @since 2.0.0
		 * @link https://developer.wordpress.org/reference/hooks/nav_menu_item_args/
		 *
		 * @param  stdClass $args      An object of wp_nav_menu() arguments.
		 * @param  WP_Post  $menu_item Menu item data object.
		 * @param  int      $depth     Depth of menu item. Used for padding.
		 * @return object
		 */
		public function menu_item_label( $args, $menu_item, $depth ) {
			// Do nothing if ACF is not active.
			if ( ! function_exists( 'get_field' ) ) {
				return $args;
			}

			$label = get_field( '_nc_label', $menu_item->ID );

			if ( $label ) {
				$args->before = $label . ' ';
			}

			return $args;
		}
	}
}
