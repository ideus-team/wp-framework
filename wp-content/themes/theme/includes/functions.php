<?php
/**
 * Custom except
 */
function nc_excerpt( $args = array() ) {
  $args = wp_parse_args( $args, array(
    'num_words' => 25,
    'more'      => '… →',
  ) );

  $excerpt = wp_trim_words( get_the_content(), $args['num_words'], $args['more'] );
  echo apply_filters( 'the_excerpt', $excerpt );
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
 * Get remote JSON & cache with Transients API
 */
function nc_remote_api_get( $api_url, $expiration = HOUR_IN_SECONDS ) {
  $api_url_hash = 'nc_cache_' . md5( $api_url );
  $cache = get_transient( $api_url_hash );

  if ( $cache ) {
    $body = $cache;
  } else {
    $request = wp_remote_get( $api_url );

    if ( is_wp_error( $request ) ) {
      return false;
    }

    $body = wp_remote_retrieve_body( $request );

    if ( $expiration ) {
      set_transient( $api_url_hash, $body, $expiration );
    }
  }

  return json_decode( $body );
}


/**
 * Get the page or post slug
 */
if ( ! function_exists( 'get_the_slug' ) ) {
  function get_the_slug( $post = 0 ) {
    $post = get_post( $post );

    $slug = isset( $post->post_name ) ? $post->post_name : '';
    $id = isset( $post->ID ) ? $post->ID : 0;

    return apply_filters( 'the_slug', $slug, $id );
  }
}

/**
 * Display the page or post slug
 *
 * Uses get_the_slug()
 */
if ( ! function_exists( 'the_slug' ) ) {
  function the_slug() {
    $slug = get_the_slug();

    echo $slug;
  }
}


/**
 * Insert something after paragraph #
 */
function nc_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
  $closing_p = '</p>';
  $paragraphs = explode( $closing_p, $content );

  foreach ($paragraphs as $index => $paragraph) {
    if ( trim( $paragraph ) ) {
      $paragraphs[$index] .= $closing_p;
    }

    if ( $paragraph_id == $index + 1 ) {
      $paragraphs[$index] .= $insertion;
    }
  }

  return implode( '', $paragraphs );
}
