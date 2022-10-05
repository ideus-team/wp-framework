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
 * Get YouTube/Vimeo video type & ID
 *
 * @param  string $url YouTube or Vimeo video URL
 * @return array       Video type & ID
 */
function nc_determine_video_url( $url ) {
  $is_match_youtube = preg_match( '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/', $url, $youtube_matches );

  $is_match_vimeo = preg_match( '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/', $url, $vimeo_matches );

  if ( $is_match_youtube ) {
    $video_type = 'youtube';
    $video_id   = $youtube_matches[5];
  } elseif ( $is_match_vimeo ) {
    $video_type = 'vimeo';
    $video_id   = $vimeo_matches[5];
  } else {
    $video_type = 'none';
    $video_id   = 0;
  }

  $data = array(
    'type' => $video_type,
    'id'   => $video_id,
  );

  return $data;
}


/**
 * Get YouTube thumbnail
 *
 * @param  string $video_id YouTube video ID
 * @param  string $size     Thumbnail size: hqdefault / sddefault / maxresdefault
 * @return string           Thumbnail URL
 */
function nc_get_youtube_thumb( $video_id, $size = 'sddefault' ) {
  $thumbnail_url = 'https://i.ytimg.com/vi/' . $video_id . '/' . $size . '.jpg';

  return $thumbnail_url;
}


/**
 * Get Vimeo thumbnail
 *
 * @param  string $video_id Vimeo video ID
 * @param  string $size     Thumbnail size: thumbnail_small / thumbnail_medium / thumbnail_large
 * @return string           Thumbnail URL
 */
function nc_get_vimeo_thumb( $video_id, $size = 'thumbnail_large' ) {
  $data = nc_remote_api_get( 'https://vimeo.com/api/v2/video/' . $video_id . '.json' );
  $thumbnail_url = str_replace( 'http://', 'https://', $data[0]->$size );

  return $thumbnail_url;
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
