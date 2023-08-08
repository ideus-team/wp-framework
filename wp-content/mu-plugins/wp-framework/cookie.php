<?php
/**
 * Set auth cookie age
 */
add_action( 'init', function() {
  add_filter( 'auth_cookie_expiration', function() {
    return YEAR_IN_SECONDS;
  } );
} );
