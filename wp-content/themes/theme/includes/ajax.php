<?php
/**
 * Processing AJAX request, type: ncAction
 */
/*
add_action( 'wp_ajax_ncAction', 'ncAction_callback' );
add_action( 'wp_ajax_nopriv_ncAction', 'ncAction_callback' );
function ncAction_callback() {
  $result = array();

  if ( ! $_POST['postdata'] ) {
    $result['error'] = 'Empty postdata';
  } else {
    $args = wp_parse_args( $_POST['postdata'], array(
      '_wpnonce' => '',
    ) );

    if ( ! wp_verify_nonce( $args['_wpnonce'] ) ) {
      $result['error'] = 'Nonce failed!';
    } else {
      $result = $args;
    }
  }

  if ( ! $result['error'] ) {
    wp_send_json_success( $result );
  } else {
    wp_send_json_error( $result );
  }
}
*/
