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
 * Fix phone number for links
 */
function nc_tel( $phone = '' ) {
  $patterns[0] = '/\ /';
  $patterns[1] = '/\./';
  $patterns[2] = '/\(/';
  $patterns[3] = '/\)/';
  $patterns[4] = '/\-/';

  return preg_replace( $patterns, '', $phone );
}


/**
 * Get YouTube Video ID
 * Source: http://code.runnable.com/VUpjz28i-V4jETgo/get-youtube-video-id-from-url-for-php
 */
function nc_get_youtube_id( $url ) {
  $video_id = false;
  $url      = parse_url( $url );

  if ( strcasecmp( $url['host'], 'youtu.be' ) === 0 ) {
    #### (dontcare)://youtu.be/<video id>
    $video_id = substr( $url['path'], 1 );
  } elseif ( strcasecmp( $url['host'], 'www.youtube.com' ) === 0 ) {
    if ( isset( $url['query'] ) ) {
      parse_str( $url['query'], $url['query'] );

      if ( isset( $url['query']['v'] ) ) {
        #### (dontcare)://www.youtube.com/(dontcare)?v=<video id>
        $video_id = $url['query']['v'];
      }
    }

    if ( $video_id == false ) {
      $url['path'] = explode( '/', substr( $url['path'], 1 ) );

      if ( in_array( $url['path'][0], array( 'e', 'embed', 'v' ) ) ) {
        #### (dontcare)://www.youtube.com/(whitelist)/<video id>
        $video_id = $url['path'][1];
      }
    }
  }

  return $video_id;
}


/**
 * Clean up script tags
 */
add_filter( 'script_loader_tag', 'nc_clean_script_tag' );
function nc_clean_script_tag( $input ) {
  $input = str_replace( ' type="text/javascript"', '', $input );
  return $input;
}
