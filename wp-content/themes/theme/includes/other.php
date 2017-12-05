<?php
/**
 * Modify except
 */
function nc_excerpt( $num_words = 25, $more = '… →' ) {
  $excerpt = wp_trim_words( get_the_excerpt(), $num_words, $more );
  echo apply_filters( 'the_excerpt', $excerpt );
}

add_filter( 'excerpt_more', 'nc_excerpt_more' );
function nc_excerpt_more( $more ) {
  return '…';
}

add_filter( 'excerpt_length', 'nc_excerpt_length' );
function nc_excerpt_length( $length ) {
  return 20;
}


/**
 * Clean up script tags
 */
add_filter( 'script_loader_tag', 'nc_clean_script_tag' );
function nc_clean_script_tag( $input ) {
  $input = str_replace( ' type="text/javascript"', '', $input );
  return $input;
}
