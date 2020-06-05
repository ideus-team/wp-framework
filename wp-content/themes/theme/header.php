<!doctype html>
<html class="l-html no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <style>
    @-ms-viewport {
      width: device-width;
    }
    @viewport {
      width: device-width;
    }
  </style>

  <?php if ( ! has_site_icon() ) : ?>

    <link rel="shortcut icon" href="<?php echo home_url( '/favicon.ico' ); ?>">
    <link rel="manifest" href="<?php echo home_url( '/site.webmanifest' ); ?>">
    <link rel="apple-touch-icon" href="<?php echo home_url( '/icon.png' ); ?>">

  <?php endif; ?>

  <!--<meta name="theme-color" content="#ed1c24">-->

  <?php wp_head(); ?>
  <?php get_template_part( 'template-parts/scripts/header' ); ?>
</head>
<body <?php body_class(); ?>>

  <?php get_template_part( 'template-parts/scripts/body' ); ?>

  <div class="l-wrapper">
    <header class="l-siteHeader">
      <div class="b-siteHeader">
        <div class="l-siteLogo">
          <?php
          $siteLogo__tag  = ( is_front_page() && ! is_paged() ) ? 'h1' : 'div';
          $siteLogo__link = ( is_front_page() && ! is_paged() ) ? '' : ' href="' . home_url() . '"';
          ?>
          <<?php echo $siteLogo__tag; ?> class="b-siteLogo" itemscope itemtype="http://schema.org/Organization">
            <a class="b-siteLogo__link"<?php echo $siteLogo__link; ?> itemprop="url">
              <img class="b-siteLogo__icon" src="<?php echo get_theme_file_uri( 'assets/img/blocks/siteLogo/siteLogo-logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" itemprop="logo">
            </a>
          </<?php echo $siteLogo__tag; ?>>
        </div>

        <?php get_search_form(); ?>

        <?php if ( has_nav_menu( 'header' ) ) : ?>

          <nav class="l-mainNavigation">
            <?php
            wp_nav_menu( array(
              'theme_location' => 'header',
              'container'      => false,
              'menu_class'     => 'b-mainNavigation',
              'fallback_cb'    => false,
              'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
              'depth'          => 1,
              'walker'         => new nc_Walker_Nav_Menu,
            ) );
            ?>
          </nav>

        <?php endif; ?>

      </div>
    </header>

    <div class="l-content">
