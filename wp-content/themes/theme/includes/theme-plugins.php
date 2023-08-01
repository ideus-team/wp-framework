<?php
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
