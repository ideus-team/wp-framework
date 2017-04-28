<?php
/*
 * Обрабатываем AJAX-запрос типа ncAction
 */
/*
add_action( 'wp_ajax_ncAction', 'ncAction_callback' );
add_action( 'wp_ajax_nopriv_ncAction', 'ncAction_callback' );
function ncAction_callback() {
  $args = wp_parse_args( $_POST, array(
    'test' => false,
  ) );

  $result = array(
    'test' => $args['test'],
  );

  if ( $result['test'] ) {
    wp_send_json_success( $result );
  } else {
    wp_send_json_error( $result );
  }
}
*/
