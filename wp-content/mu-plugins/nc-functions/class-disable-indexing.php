<?php
namespace iDeus;

if ( ! class_exists( '\iDeus\Disable_Indexing' ) ) {

  /**
   * Close from search engines indexing for dev, stage environment
   */
  final class Disable_Indexing {

    /**
     * Class initialization
     */
    public function __construct() {
      add_action( 'init', array( __CLASS__, 'disable_indexing' ) );
    }


    public static function disable_indexing(): void {

      if ( ! self::is_blocking_on() ) {
        return;
      }

      self::block_search_agents();

      add_filter( 'wp_headers', array( __CLASS__, 'HTTP_header' ) );
      add_filter( 'robots_txt', array( __CLASS__, 'robots_txt' ) );
      add_filter( 'wp_robots', array( __CLASS__, 'robots_meta_tag' ), 999 );
    }


    /**
     * Checks whether we should disable indexing.
     */
    private static function is_blocking_on(): bool {

      if ( in_array( wp_get_environment_type(), array( 'production', 'local' ), true ) ) {
        return false;
      }

      if ( current_user_can( 'administrator' ) ) {
        return false;
      }

      return true;
    }


    /**
     * 403 response for search agents.
     */
    private static function block_search_agents(): void {
      $robots = 'libwww|Wget|LWP|damnBot|BBBike|spider|crawl|google|bing|yandex|msnbot';
      $user_agent = ( $_SERVER['HTTP_USER_AGENT'] ?? '' );

      if ( preg_match( "/$robots/i", $user_agent ) ) {
        http_response_code( 403 );

        die( 'Indexing of this site is Forbidden for robots.' );
      }
    }


    public static function HTTP_header( array $headers ): array {
      $headers['X-Robots-Tag'] = 'noindex, nofollow';

      return $headers;
    }


    public static function robots_txt(): string {
      return "User-agent: *\nDisallow: /";
    }


    /**
     * Callback for hook `wp_robots`.
     * Adds `<meta name='robots' content='noindex, follow' />` HTML meta tag.
     */
    public static function robots_meta_tag( array $robots ): array {
      $robots['noindex'] = true;
      $robots['nofollow'] = true;
      unset( $robots['follow'] );

      return $robots;
    }

  }

  new \iDeus\Disable_Indexing();
}
