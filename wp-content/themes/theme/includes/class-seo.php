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
		 * Redirect attachment to the exact file instead of the attachment page.
		 *
		 * @since 2.0.0
		 */
		public function attachment_redirect() {
			if ( is_attachment() ) {
				$url = wp_get_attachment_url( get_queried_object_id() );
				wp_safe_redirect( $url, 301 );
				exit();
			}
		}
	}
}
