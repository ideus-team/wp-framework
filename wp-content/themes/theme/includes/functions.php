<?php
/**
 * Theme functions.
 *
 * @package WP-framework
 * @since 2.0.0
 */

/**
 * Show breadcrumbs
 *
 * @since 2.0.0
 *
 * @param  string [ $sep  = '' ]      Розділювач. За замовчуванням ''.
 * @param  array  [ $l10n = array() ] Для локалізації. Див. змінну $default_l10n.
 * @param  array  [ $args = array() ] Опції. Див. змінну $def_args.
 * @return void                       Виводить на екран HTML код.
 */
function nc_breadcrumbs( $sep = '', $l10n = array(), $args = array() ) {
	$breadcrumbs = new \iDeus\Framework\Breadcrumbs();
	echo $breadcrumbs->get_crumbs( $sep, $l10n, $args );
}


/**
 * Custom except.
 *
 * @since 2.0.0
 *
 * @param  array $args Arguments.
 * @return string      Custom except.
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
 * Fix phone number for links.
 *
 * @since 2.0.0
 *
 * @param  string $phone Phone number.
 * @return string        Fixed phone number.
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
 * Get remote JSON & cache with Transients API.
 *
 * @since 2.0.0
 *
 * @param  string $api_url    URL to retrieve.
 * @param  array  $args       Optional. Request arguments. Default empty array. See WP_Http::request() for information on accepted arguments.
 * @param  int    $expiration Time until expiration in seconds.
 * @return object|false       The response or false on failure.
 */
function nc_remote_api_get( $api_url, $args = array(), $expiration = HOUR_IN_SECONDS ) {
	// Create cache key based on URL.
	$cache_key     = 'nc_cache_' . md5( $api_url );
	$cached_result = get_transient( $cache_key );

	if ( false !== $cached_result ) {
		// Get cached result if exists.
		$body = $cached_result;
	} else {
		// Use WordPress HTTP API to get response.
		$request = wp_remote_get( $api_url, $args );

		// Check if request was successful.
		if ( is_wp_error( $request ) ) {
			return false;
		}

		$body = wp_remote_retrieve_body( $request );

		// Cache result.
		if ( $expiration ) {
			set_transient( $cache_key, $body, $expiration );
		}
	}

	return json_decode( $body );
}


/**
 * Get YouTube/Vimeo video type & ID.
 *
 * @since 2.0.0
 *
 * @param  string $url YouTube or Vimeo video URL.
 * @return array       Video type & ID.
 */
function nc_determine_video_url( $url ) {
	$is_match_youtube = preg_match( '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/|shorts\/)?)([\w\-]+)(\S+)?$/', $url, $youtube_matches );

	$is_match_vimeo = preg_match( '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/', $url, $vimeo_matches );

	if ( $is_match_youtube ) {
		$video_type = 'youtube';
		$video_id   = $youtube_matches[5];
	} elseif ( $is_match_vimeo ) {
		$video_type = 'vimeo';
		$video_id   = $vimeo_matches[5];
	} else {
		$video_type = false;
		$video_id   = 0;
	}

	$data = array(
		'type' => $video_type,
		'id'   => $video_id,
	);

	return $data;
}


/**
 * Get YouTube thumbnail.
 *
 * @since 2.0.0
 *
 * @param  string $video_id YouTube video ID.
 * @param  string $size     Thumbnail size: hqdefault / sddefault / maxresdefault.
 * @return string           Thumbnail URL.
 */
function nc_get_youtube_thumb( $video_id, $size = 'sddefault' ) {
	$thumbnail_url = 'https://i.ytimg.com/vi/' . $video_id . '/' . $size . '.jpg';

	return $thumbnail_url;
}


/**
 * Get Vimeo thumbnail.
 *
 * @since 2.0.0
 *
 * @param  string $video_id Vimeo video ID.
 * @param  string $size     Thumbnail size: 640 | 1280.
 * @return string           Thumbnail URL.
 */
function nc_get_vimeo_thumb( $video_id, $size = '640' ) {
	$data          = nc_remote_api_get( 'https://vimeo.com/api/v2/video/' . $video_id . '.json' );
	$thumbnail_url = str_replace( '-d_640', '-d_' . $size, $data[0]->thumbnail_large );

	return $thumbnail_url;
}


/**
 * Get the page or post slug.
 *
 * @since 2.0.0
 *
 * @param  int    $post Post ID.
 * @return string       Post slug.
 */
if ( ! function_exists( 'get_the_slug' ) ) {
	function get_the_slug( $post = 0 ) {
		$post = get_post( $post );

		$slug = isset( $post->post_name ) ? $post->post_name : '';
		$id   = isset( $post->ID ) ? $post->ID : 0;

		return apply_filters( 'the_slug', $slug, $id );
	}
}


/**
 * Display the page or post slug.
 *
 * Uses get_the_slug().
 *
 * @since 2.0.0
 *
 * @return void Echo post slug.
 */
if ( ! function_exists( 'the_slug' ) ) {
	function the_slug() {
		$slug = get_the_slug();

		echo $slug;
	}
}


/**
 * Insert something after paragraph #.
 *
 * @since 2.0.0
 *
 * @param  string $insertion     Text to be inserted.
 * @param  int    $paragraph_num Number of paragraph to insert.
 * @param  string $content       Text where to insert.
 * @return string                Final text.
 */
function nc_insert_after_paragraph( $insertion, $paragraph_num, $content ) {
	$closing_p  = '</p>';
	$paragraphs = explode( $closing_p, $content );

	foreach ( $paragraphs as $index => $paragraph ) {
		if ( trim( $paragraph ) ) {
			$paragraphs[ $index ] .= $closing_p;
		}

		if ( $paragraph_num === $index + 1 ) {
			$paragraphs[ $index ] .= $insertion;
		}
	}

	return implode( '', $paragraphs );
}


/**
 * Using Akismet in Custom Forms.
 *
 * $content['comment_author']       Name.
 * $content['comment_author_email'] Email.
 * $content['comment_author_url']   Website.
 * $content['comment_content']      Message.
 *
 * @since 2.5.0
 *
 * @link https://www.binarymoon.co.uk/2010/03/akismet-plugin-theme-stop-spam-dead/
 *
 * @param  string[] $content Content to check for spam, see description.
 * @return bool              Is spam.
 */
function nc_check_spam( $content ) {
	// Innocent until proven guilty.
	$is_spam = false;

	$content = (array) $content;

	if ( function_exists( 'akismet_init' ) ) {
		$wpcom_api_key = get_option( 'wordpress_api_key' );

		if ( ! empty( $wpcom_api_key ) ) {
			global $akismet_api_host, $akismet_api_port;

			// Set remaining required values for akismet api.
			$content['user_ip']    = preg_replace( '/[^0-9., ]/', '', $_SERVER['REMOTE_ADDR'] );
			$content['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
			$content['referrer']   = $_SERVER['HTTP_REFERER'];
			$content['blog']       = get_option( 'home' );

			if ( empty( $content['referrer'] ) ) {
				$content['referrer'] = get_permalink();
			}

			$query_string = '';

			foreach ( $content as $key => $data ) {
				if ( ! empty( $data ) ) {
					$query_string .= $key . '=' . rawurlencode( stripslashes( $data ) ) . '&';
				}
			}

			$response = akismet_http_post( $query_string, $akismet_api_host, '/1.1/comment-check', $akismet_api_port );

			if ( 'true' === $response[1] ) {
				update_option( 'akismet_spam_count', get_option( 'akismet_spam_count' ) + 1 );
				$is_spam = true;
			}
		}
	}

	return $is_spam;
}
