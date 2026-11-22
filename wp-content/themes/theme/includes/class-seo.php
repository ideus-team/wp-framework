<?php
/**
 * Class SEO.
 *
 * @package WP-framework
 * @since 2.0.0
 */

namespace iDeus\Theme;

if ( ! class_exists( '\iDeus\Theme\SEO' ) ) {
	/**
	 * SEO.
	 *
	 * @since 2.0.0
	 */
	class SEO {
		/**
		 * Class initialization.
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			// Remove author pages.
			add_action( 'wp', array( $this, 'remove_author_page' ) );

			// Remove author pages from sitemap.
			add_filter( 'wp_sitemaps_add_provider', array( $this, 'remove_author_pages_from_sitemap' ), 10, 2 );

			// Hide users list from REST API for guests.
			add_filter( 'rest_endpoints', array( $this, 'remove_users_rest_endpoints' ) );

			// Redirect attachment to the exact file instead of the attachment page.
			add_action( 'template_redirect', array( $this, 'attachment_redirect' ), 10 );
		}


		/**
		 * Remove author pages.
		 *
		 * @since 2.0.0
		 */
		public function remove_author_page() {
			global $wp_query;

			if ( is_author() ) {
				$wp_query->set_404();
				status_header( 404 );
			}
		}


		/**
		 * Remove author pages from sitemap.
		 *
		 * @since 2.0.0
		 *
		 * @param  WP_Sitemaps_Provider $provider Instance of a WP_Sitemaps_Provider.
		 * @param  string               $name     Name of the sitemap provider.
		 * @return WP_Sitemaps_Provider
		 */
		public function remove_author_pages_from_sitemap( $provider, $name ) {
			if ( 'users' === $name ) {
				return false;
			}

			return $provider;
		}


		/**
		 * Hide users list from REST API for guests (/wp/v2/users), so user names can't be enumerated.
		 * Logged-in users keep it: the editor uses these endpoints.
		 *
		 * @since 2.32.0
		 *
		 * @param  array $endpoints The available endpoints.
		 * @return array
		 */
		public function remove_users_rest_endpoints( $endpoints ) {
			if ( ! is_user_logged_in() ) {
				unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
			}

			return $endpoints;
		}


		/**
		 * Redirect attachment to the exact file instead of the attachment page.
		 *
		 * @since 2.0.0
		 */
		public function attachment_redirect() {
			if ( is_attachment() ) {
				$url = wp_get_attachment_url( get_queried_object_id() );

				if ( $url ) {
					// Not wp_safe_redirect(): the file may be on another host (CDN, S3), and the URL comes from WordPress itself.
					wp_redirect( $url, 301 ); // phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
					exit();
				}
			}
		}
	}
}
