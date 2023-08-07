<?php
/**
 * Example: Processing AJAX request, type 'nc_example'
 */
// add_action( 'wp_ajax_nc_example', 'nc_example_callback' );
// add_action( 'wp_ajax_nopriv_nc_example', 'nc_example_callback' );
function nc_example_callback() {
  $result = array();

  if ( ! $_POST['postdata'] ) {
    $result['error'] = 'Empty postdata';
  } else {
    $args = wp_parse_args( $_POST['postdata'], array(
      '_wpnonce' => '',
    ) );

    if ( ! wp_verify_nonce( $args['_wpnonce'] ) ) {
      $result['error'] = 'An error occurred, please refresh the page and try again';
    } else {
      $result['args'] = $args;
    }
  }

  if ( ! $result['error'] ) {
    wp_send_json_success( $result );
  } else {
    wp_send_json_error( $result );
  }
}