<?php
/** include all AJAX files */
foreach ( glob( get_stylesheet_directory() . '/includes/ajax/*.php' ) as $file ) {
  require_once( $file );
}


/**
 * Processing AJAX request, type: nc_action
 */
/*
add_action( 'wp_ajax_nc_action', 'nc_action_callback' );
add_action( 'wp_ajax_nopriv_nc_action', 'nc_action_callback' );
function nc_action_callback() {
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
*/
