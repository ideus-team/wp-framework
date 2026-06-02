<?php
/**
 * Plugin Name: OTF Regenerate Thumbnails
 * Plugin URI: https://github.com/gambitph/WP-OTF-Regenerate-Thumbnails
 * Description: Automatically regenerates your thumbnails on the fly (OTF) after changing the thumbnail sizes or switching themes.
 * Author: Benjamin Intal - Gambit Technologies Inc
 * Version: 0.4 (forked by iDeus)
 * Author URI: http://gambit.ph
 */

/**
 * Simple but effectively resizes images on the fly. Doesn't upsize, just downsizes like how WordPress likes it.
 * If the image already exists, it's served. If not, the image is resized to the specified size, saved for
 * future use, then served.
 *
 * @author  Benjamin Intal - Gambit Technologies Inc
 * @see https://wordpress.stackexchange.com/questions/53344/how-to-generate-thumbnails-when-needed-only/124790#124790
 * @see http://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
 */

if ( ! function_exists( 'gambit_otf_regen_thumbs_media_downsize' ) ) {
	/**
	 * The downsizer. This only does something if the existing image size doesn't exist yet.
	 *
	 * @param bool  $out  boolean false.
	 * @param int   $id   Attachment ID.
	 * @param mixed $size The size name, or an array containing the width & height.
	 * @return mixed False if the custom downsize failed, or an array of the image if successful.
	 */
	function gambit_otf_regen_thumbs_media_downsize( $out, $id, $size ) {

		// Gather all the different image sizes of WP (thumbnail, medium, large) and,
		// all the theme/plugin-introduced sizes.
		global $_gambit_otf_regen_thumbs_all_image_sizes;

		if ( ! isset( $_gambit_otf_regen_thumbs_all_image_sizes ) ) {
			global $_wp_additional_image_sizes;

			$_gambit_otf_regen_thumbs_all_image_sizes = array();
			$interim_sizes                            = get_intermediate_image_sizes();

			foreach ( $interim_sizes as $size_name ) {
				if ( in_array( $size_name, array( 'thumbnail', 'medium', 'large' ), true ) ) {
					$_gambit_otf_regen_thumbs_all_image_sizes[ $size_name ]['width']  = get_option( $size_name . '_size_w' );
					$_gambit_otf_regen_thumbs_all_image_sizes[ $size_name ]['height'] = get_option( $size_name . '_size_h' );
					$_gambit_otf_regen_thumbs_all_image_sizes[ $size_name ]['crop']   = (bool) get_option( $size_name . '_crop' );
				} elseif ( isset( $_wp_additional_image_sizes[ $size_name ] ) ) {
					$_gambit_otf_regen_thumbs_all_image_sizes[ $size_name ] = $_wp_additional_image_sizes[ $size_name ];
				}
			}
		}

		// This now contains all the data that we have for all the image sizes.
		$all_sizes = $_gambit_otf_regen_thumbs_all_image_sizes;

		// If image size exists let WP serve it like normally.
		$image_data = wp_get_attachment_metadata( $id );

		// Image attachment doesn't exist.
		if ( ! is_array( $image_data ) ) {
			return false;
		}

		// If the size given is a string / a name of a size.
		if ( is_string( $size ) ) {

			// If WP doesn't know about the image size name, then we can't really do any resizing of our own.
			if ( empty( $all_sizes[ $size ] ) ) {
				return false;
			}

			// If the size has already been previously created, use it.
			if ( ! empty( $image_data['sizes'][ $size ] ) && ! empty( $all_sizes[ $size ] ) ) {

				// Verify if the file ACTUALLY exists on disk to cover physical deletions.
				$attached_file = get_attached_file( $id );

				// Prevent TypeError in PHP 8+ if the original file is missing.
				if ( ! $attached_file ) {
					return false;
				}

				$file_path = dirname( $attached_file ) . '/' . $image_data['sizes'][ $size ]['file'];

				// Only skip regeneration if the file is physically present.
				if ( file_exists( $file_path ) ) {
					// But only if the size remained the same.
					if ( (int) $all_sizes[ $size ]['width'] === (int) $image_data['sizes'][ $size ]['width']
						&& (int) $all_sizes[ $size ]['height'] === (int) $image_data['sizes'][ $size ]['height']
					) {
						return false;
					}

					// Or if the size is different and we found out before that the size really was different.
					if ( ! empty( $image_data['sizes'][ $size ]['width_query'] )
						&& ! empty( $image_data['sizes'][ $size ]['height_query'] )
					) {
						if ( (int) $image_data['sizes'][ $size ]['width_query'] === (int) $all_sizes[ $size ]['width']
							&& (int) $image_data['sizes'][ $size ]['height_query'] === (int) $all_sizes[ $size ]['height']
						) {
							return false;
						}
					}
				}
			}

			// Resize the image.
			$resized = image_make_intermediate_size(
				get_attached_file( $id ),
				$all_sizes[ $size ]['width'],
				$all_sizes[ $size ]['height'],
				$all_sizes[ $size ]['crop']
			);

			// Resize somehow failed.
			if ( ! $resized ) {
				return false;
			}

			// Save the new size in WP.
			$image_data['sizes'][ $size ] = $resized;

			// Save some additional info so that we'll know next time whether we've resized this before.
			$image_data['sizes'][ $size ]['width_query']  = $all_sizes[ $size ]['width'];
			$image_data['sizes'][ $size ]['height_query'] = $all_sizes[ $size ]['height'];

			wp_update_attachment_metadata( $id, $image_data );

			// Serve the resized image.
			$att_url = wp_get_attachment_url( $id );
			return array( dirname( $att_url ) . '/' . $resized['file'], $resized['width'], $resized['height'], true );

		// If the size given is a custom array size.
		} elseif ( is_array( $size ) ) {
			$image_path = get_attached_file( $id );

			// Prevent TypeError in PHP 8+ if the original file is missing.
			if ( ! $image_path ) {
				return false;
			}

			$crop       = array_key_exists( 2, $size ) ? $size[2] : true;
			$new_width  = $size[0];
			$new_height = $size[1];

			// If crop is false, calculate new image dimensions.
			if ( ! $crop ) {
				if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'photon' ) ) {
					add_filter( 'jetpack_photon_override_image_downsize', '__return_true' );
					$true_data = wp_get_attachment_image_src( $id, 'large' );
					remove_filter( 'jetpack_photon_override_image_downsize', '__return_true' );
				} else {
					$true_data = wp_get_attachment_image_src( $id, 'large' );
				}

				if ( $true_data[1] > $true_data[2] ) {
					// Width > height.
					$ratio      = $true_data[1] / $size[0];
					$new_height = (int) round( $true_data[2] / $ratio );
					$new_width  = $size[0];
				} else {
					// Height > width.
					$ratio      = $true_data[2] / $size[1];
					$new_height = $size[1];
					$new_width  = (int) round( $true_data[1] / $ratio );
				}
			}

			// Get the extension for strict validation, converted to lowercase to avoid .JPG failing.
			$ext_regex = pathinfo( $image_path, PATHINFO_EXTENSION );
			$image_ext = strtolower( $ext_regex );

			// Check if image. Added 'avif' for modern WP support.
			if ( ! in_array( $image_ext, array( 'jpg', 'jpeg', 'png', 'gif', 'webp', 'avif' ), true ) ) {
				return false;
			}

			$original_size = wp_getimagesize( $image_path );

			// Bail if original size can't be found.
			if ( empty( $original_size ) ) {
				return false;
			}

			$sizes = image_resize_dimensions( $original_size[0], $original_size[1], $size[0], $size[1], true );

			// Calculate target path separately to not mutate original $image_path string.
			if ( empty( $sizes ) ) {
				$target_path = preg_replace( '/^(.*)\.' . preg_quote( $ext_regex, '/' ) . '$/', sprintf( '$1-%sx%s.%s', $new_width, $new_height, $ext_regex ), $image_path );
			} else {
				$target_path = preg_replace( '/^(.*)\.' . preg_quote( $ext_regex, '/' ) . '$/', sprintf( '$1-%sx%s.%s', $sizes[4], $sizes[5], $ext_regex ), $image_path );
			}

			$att_url = wp_get_attachment_url( $id );

			// If it already exists, serve it.
			if ( file_exists( $target_path ) ) {
				return array( dirname( $att_url ) . '/' . wp_basename( $target_path ), $new_width, $new_height, $crop );
			}

			// If not, create a resized copy from the original image.
			$resized = image_make_intermediate_size(
				$image_path,
				$size[0],
				$size[1],
				$crop
			);

			// Resize somehow failed.
			if ( ! $resized ) {
				return false;
			}

			// Get attachment meta so we can add new size.
			$image_data = wp_get_attachment_metadata( $id );

			// Save the new size in WP so that it can also perform actions on it.
			if ( is_array( $image_data ) ) {
				$image_data['sizes'][ $size[0] . 'x' . $size[1] ] = $resized;
				wp_update_attachment_metadata( $id, $image_data );
			}

			// Then serve it.
			return array( dirname( $att_url ) . '/' . $resized['file'], $resized['width'], $resized['height'], $crop );
		}

		return false;
	}
	add_filter( 'image_downsize', 'gambit_otf_regen_thumbs_media_downsize', 10, 3 );
}
