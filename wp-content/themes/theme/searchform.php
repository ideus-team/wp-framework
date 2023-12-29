<?php
/**
 * Searchform.
 *
 * @package WP-framework
 * @since 2.0.0
 */

?>

<div class="l-siteSearch">
	<form class="b-siteSearch" role="search" action="<?php echo esc_url( home_url() ); ?>" method="get">
		<label class="b-siteSearch__search">
			<span class="b-siteSearch__label g-visuallyhidden"><?php esc_html_e( 'Search' ); ?>:</span>
			<input class="b-siteSearch__input" type="search" name="s" spellcheck="true">
		</label>

		<input class="b-siteSearch__button" type="submit" value="<?php esc_attr_e( 'Search' ); ?>">
	</form>
</div>
