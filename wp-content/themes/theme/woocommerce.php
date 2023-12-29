<?php
/**
 * Template for WooCommerce.
 *
 * @package WP-framework
 * @since 2.0.0
 */

get_header();
?>

<main class="l-contentText">

	<section class="b-contentText">
		<h2 class="b-contentText__title"><?php woocommerce_page_title(); ?></h2>
		<div class="b-contentText__content"><?php woocommerce_content(); ?></div>
	</section>

</main>

<?php get_footer(); ?>
