<?php
/**
 * Walker for wp_nav_menu
 */
class nc_Walker_Nav_Menu extends Walker_Nav_Menu {
  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = str_repeat( $t, $depth );
    $output .= "{$n}{$indent}<ul class=\"" . $args->menu_class . "__submenu -depth_" . ( $depth + 1 ) . " sub-menu\">{$n}";
  }

  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;
    $classes[] = '-depth_'. ($depth + 1);
    $classes[] = '-id_' . $item->ID;

    if ( function_exists( 'get_field' ) ) {
      $classes[] = get_field( '_nc_class', $item->ID );
    }

    if ( in_array( 'current-menu-item', $classes ) || in_array( 'current-menu-ancestor', $classes ) ) {
      $classes[] =  '-state_active';
    }

    $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
    $class_names = $class_names ? ' class="' . $args->menu_class .'__item ' . esc_attr( $class_names ) . '"' : '';

    $id = '';

    $output .= $indent . '<li' . $id . $class_names . '>';

    $atts = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title            : '';
    $atts['target'] = ! empty( $item->target )     ? $item->target                : '';
    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn                   : '';
    $atts['href']   = ! empty( $item->url )        ? $item->url                   : '';
    $atts['class']  = ! empty( $args->menu_class ) ? $args->menu_class . '__link' : '';

    $atts['class'] .= ' -depth_' . ($depth + 1);

    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

    $attributes = '';
    foreach ( $atts as $attr => $value ) {
      if ( ! empty( $value ) ) {
        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }

    $title = apply_filters( 'the_title', $item->title, $item->ID );

    $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

    $item_output = $args->before;
    $item_output .= '<a'. $attributes . '>';
    $item_output .= $args->link_before . $title . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;
    $item_output .= ( ! empty( $item->description ) ) ? '<span class="' . $args->menu_class . '__descr">' . $item->description . '</span>' : '';

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }
}
