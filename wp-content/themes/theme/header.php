<?php
/**
 * Header template.
 *
 * @package WP-framework
 * @since 2.0.0
 */

?>
<!doctype html>
<html class="l-html" <?php language_attributes(); ?>>
<head>
	<?php get_template_part( 'template-parts/scripts/header-start' ); ?>

	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php if ( ! has_site_icon() ) : ?>

		<link rel="icon" href="<?php echo esc_url( home_url( '/favicon.ico' ) ); ?>" sizes="any">
		<link rel="icon" href="<?php echo esc_url( home_url( '/icon.svg' ) ); ?>" type="image/svg+xml">
		<link rel="apple-touch-icon" href="<?php echo esc_url( home_url( '/icon.png' ) ); ?>">

		<link rel="manifest" href="<?php echo esc_url( home_url( '/site.webmanifest' ) ); ?>">

	<?php endif; ?>

	<!--<meta name="theme-color" content="#fafafa">-->

	<?php wp_head(); ?>
	<?php get_template_part( 'template-parts/scripts/header' ); ?>
</head>
<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>
	<?php get_template_part( 'template-parts/scripts/body' ); ?>

	<div class="l-wrapper" id="top">
		<header class="l-siteHeader">
			<div class="b-siteHeader">
				<div class="l-siteLogo">
					<?php
					$logo_tag  = ( is_front_page() && ! is_paged() ) ? 'h1' : 'div';
					$logo_link = ( is_front_page() && ! is_paged() ) ? home_url( '#top' ) : home_url();
					?>
					<<?php echo tag_escape( $logo_tag ); ?> class="b-siteLogo" itemscope itemtype="https://schema.org/Organization">
						<a class="b-siteLogo__link" href="<?php echo esc_url( $logo_link ); ?>" itemprop="url" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
							<img class="b-siteLogo__icon" src="<?php echo esc_url( get_theme_file_uri( 'assets/img/logos/siteLogo.png' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" itemprop="logo">
						</a>
					</<?php echo tag_escape( $logo_tag ); ?>>
				</div>

				<?php get_search_form(); ?>

				<?php if ( has_nav_menu( 'header' ) ) : ?>

					<nav class="l-mainNavigation">

						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'header',
								'container'      => false,
								'menu_class'     => 'b-mainNavigation',
								'fallback_cb'    => false,
								'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
								'depth'          => 1,
								'walker'         => new \iDeus\Framework\Walker_Nav_Menu(),
							)
						);
						?>

					</nav>

				<?php endif; ?>

			</div>
		</header>

		<div class="l-content">
