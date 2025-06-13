<?php
/**
 * Footer template.
 *
 * @package WP-framework
 * @since 2.0.0
 */

?>
		</div><!--content-->

		<footer class="l-siteFooter">
			<div class="b-siteFooter">

				<?php if ( has_nav_menu( 'footer' ) ) : ?>

					<div class="l-bottomNavigation" role="navigation">

						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer',
								'container'      => false,
								'menu_class'     => 'b-bottomNavigation',
								'fallback_cb'    => false,
								'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
								'depth'          => 1,
								'walker'         => new \iDeus\Framework\Walker_Nav_Menu(),
							)
						);
						?>

					</div>

				<?php endif; ?>

				<address class="l-siteCopyright vcard" itemscope itemtype="https://schema.org/Organization">
					<div class="b-siteCopyright">
						© <?php echo current_time( 'Y' ); ?>
						<a class="b-siteCopyright__link fn n org url work" href="<?php echo esc_url( home_url() ); ?>" rel="me" itemprop="name"><?php bloginfo( 'name' ); ?></a>.
						<?php esc_html_e( 'All rights reserved' ); ?>
					</div>

					<div class="b-developerCopyright">
						<a class="b-developerCopyright__link" href="https://ideus.biz/" rel="friend" target="_blank">iDeus</a>
					</div>
				</address>
			</div>
		</footer>
	</div><!--wrapper-->

	<?php wp_footer(); ?>
	<?php get_template_part( 'template-parts/scripts/footer' ); ?>

</body>
</html>
