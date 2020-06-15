    </div><!--content-->

    <footer class="l-siteFooter">
      <div class="b-siteFooter">

        <?php if ( has_nav_menu( 'footer' ) ) : ?>

          <div class="l-bottomNavigation" role="navigation">
            <?php
            wp_nav_menu( array(
              'theme_location' => 'footer',
              'container'      => false,
              'menu_class'     => 'b-bottomNavigation',
              'fallback_cb'    => false,
              'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
              'depth'          => 1,
              'walker'         => new nc_Walker_Nav_Menu,
            ) );
            ?>
          </div>

        <?php endif; ?>

        <address class="l-siteCopyright vcard" itemscope itemtype="http://schema.org/Organization">
          <div class="b-siteCopyright">© <?php echo date( 'Y' ); ?>
            <a rel="me" itemprop="name" class="b-siteCopyright__link fn n org url work" href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>. <?php _e( 'Все права защищены' ); ?>
          </div>
          <div class="b-developerCopyright"><?php _e( 'Разработано в' ); ?> <a class="b-developerCopyright__link" href="https://ideus.biz/" rel="friend" target="_blank">iDeus</a></div>
        </address>
      </div>
    </footer>
  </div><!--wrapper-->

  <?php wp_footer(); ?>
  <?php get_template_part( 'template-parts/scripts/footer' ); ?>

</body>
</html>
