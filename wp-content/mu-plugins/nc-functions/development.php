<?php
/**
 * Disable SSL verification for `wp_remote_*()` if localhost
 */
if ( 'local' === wp_get_environment_type() ) {
  add_filter( 'http_request_args', function( $parsed_args ) {
    $parsed_args['sslverify'] = false;

    return $parsed_args;
  } );
}
