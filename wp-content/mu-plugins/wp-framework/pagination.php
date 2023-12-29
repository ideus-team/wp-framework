<?php
/**
 * Pagination.
 *
 * @package WP-framework
 * @since 2.0.0
 */

/**
 * Pagination.
 *
 * @since 2.0.0
 *
 * @param  array $args Arguments.
 * @return string
 */
function nc_pagenavi( $args = array() ) {
	global $wp_query, $wp_rewrite;

	$args = wp_parse_args(
		$args,
		array(
			'query'      => $wp_query,
			'mid_size'   => 1,
			'end_size'   => 3,
			'prev_text'  => '←',
			'next_text'  => '→',
			'type'       => 'array',
			'class'      => 'b-pagination',
			'modifier'   => '',
			'found'      => false, // Show 'Found N'.
			'total'      => false, // Show 'Page N of N'.
			'total_text' => false,
			'echo'       => true,
		)
	);

	$query = $args['query'];

	$pages   = '';
	$max     = $query->max_num_pages;
	$current = get_query_var( 'paged' );

	if ( ! $current ) {
		$current = 1;
	}

	$paginate = array(
		'base'      => str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
		'total'     => $max,
		'current'   => $current,
		'mid_size'  => $args['mid_size'],
		'end_size'  => $args['end_size'],
		'prev_text' => $args['prev_text'],
		'next_text' => $args['next_text'],
		'type'      => $args['type'],
	);

	$search  = array(
		'page-numbers',
		'prev',
		'next',
		'dots',
		' current',
		'/page/1/',
	);
	$replace = array(
		$args['class'] . '__link',
		'-type_prev',
		'-type_next',
		'-type_dots',
		' -state_active',
		'',
	);

	if ( $max > 1 ) {
		$pages .= '<div class="' . $args['class'] . ( $args['modifier'] ? ' ' . $args['modifier'] : '' ) . '">' . "\r";

		if ( $args['found'] ) {
			$pages .= '<span class="' . $args['class'] . '__total">Found ' . $query->found_posts . '</span>' . "\r";
		}

		if ( $args['total'] ) {
			if ( ! $args['total_text'] ) {
				$args['total_text'] = 'Page ' . $current . ' of ' . $max;
			}

			$pages .= '<span class="' . $args['class'] . '__pages">' . $args['total_text'] . '</span>' . "\r";
		}

		$pages .= '<ul class="' . $args['class'] . '__list">' . "\r";

		$pagination_list = str_replace( $search, $replace, paginate_links( $paginate ) );
		foreach ( $pagination_list as $value ) {
			$pages .= '<li class="' . $args['class'] . '__item">' . $value . '</li>' . "\r";
		}

		$pages .= '</ul>' . "\r";

		$pages .= '</div>';
	}

	if ( $args['echo'] ) {
		echo $pages;
	} else {
		return $pages;
	}
}


/**
 * Page Navigation.
 *
 * @since 2.0.0
 *
 * @param  array $args Arguments.
 * @return string
 */
function nc_page_nav( $args = array() ) {
	global $wp_query, $wp_rewrite;

	$args = wp_parse_args(
		$args,
		array(
			'query' => $wp_query,
			'class' => 'b-pageNav',
			'next'  => 'Older Entries',
			'prev'  => 'Newer Entrie',
			'echo'  => true,
		)
	);

	$query = $args['query'];

	$pages = '';
	$max   = $query->max_num_pages;

	if ( $max > 1 ) {
		$pages .= '<div class="' . $args['class'] . '">' . "\r";

		$pages .= '<ul class="' . $args['class'] . '__list">' . "\r";

		$link_next = get_next_posts_link( $args['next'], $max );
		$link_prev = get_previous_posts_link( $args['prev'] );

		if ( $link_next ) {
			$pages .= '<li class="' . $args['class'] . '__item -type_old">' . $link_next . '</li>' . "\r";
		}
		if ( $link_prev ) {
			$pages .= '<li class="' . $args['class'] . '__item -type_new">' . $link_prev . '</li>' . "\r";
		}

		$pages .= '</ul>' . "\r";

		$pages .= '</div>';
	}

	if ( $args['echo'] ) {
		echo $pages;
	} else {
		return $pages;
	}
}
