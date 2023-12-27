<?php
/**
 * Class Breadcrumbs
 *
 * @package WP-framework
 * @since 2.1.0
 */
namespace iDeus\Framework;

if ( ! class_exists( '\iDeus\Framework\Breadcrumbs' ) ) {

	/**
	 * Breadcrumbs
	 *
	 * @since 2.1.0
	 * @link http://wp-kama.ru/id_541/samyie-hlebnyie-kroshki-breabcrumbs-dlya-wordpress.html
	 * @version 3.3.1
	 */
	class Breadcrumbs {

		public $arg;

		// Локалізація
		static $l10n = array(
			'home'       => 'Головна',
			'paged'      => 'Сторінка %d',
			'_404'       => 'Помилка 404',
			'search'     => 'Результати пошуку за запитом - <b>%s</b>',
			'author'     => 'Архів автора: <b>%s</b>',
			'year'       => 'Архів за <b>%d</b> рік',
			'month'      => 'Архів за: <b>%s</b>',
			'day'        => '',
			'attachment' => 'Медіа: %s',
			'tag'        => 'Записи за тегом: <b>%s</b>',
			'tax_tag'    => '%1$s з "%2$s" за тегом: <b>%3$s</b>',
			// tax_tag виведе: 'тип_запису з "назва таксономії" за тегом: ім'я_терміна'.
			// Якщо потрібні окремі холдери, наприклад, тільки ім'я терміна, пишемо так: 'записи за тегом: %3$s'
		);

		// Параметри за замовчуванням
		static $args = array(
			'on_front_page'   => true, // Виводити крихти на головній сторінці
			'show_post_title' => true, // Показувати назву запису в кінці (останній елемент). Для записів, сторінок, вкладень
			'show_term_title' => true, // Показувати назву елемента таксономії в кінці (останній елемент). Для міток, рубрик та інших таксономій
			'title_patt'      => '<li class="b-breadcrumbs__item -state_current">%s</li>', // Шаблон для останнього заголовка. Якщо увімкнено: show_post_title або show_term_title
			'last_sep'        => true, // Показувати останній роздільник, коли заголовок наприкінці не відображається
			'markup'          => 'schema.org', // 'markup' - мікророзмітка. Може бути: 'rdf.data-vocabulary.org', 'schema.org', '' - без мікророзмітки
																				 // або можна вказати свій масив розмітки:
																				 // array( 'wrappatt'=>'<div class="kama_breadcrumbs">%s</div>', 'linkpatt'=>'<a href="%s">%s</a>', 'sep_after'=>'', )
			'priority_tax'    => array('category'), // Пріоритетні таксономії, потрібно коли запис у кількох таксономіях
			'priority_terms'  => array(), // 'priority_terms' - пріоритетні елементи таксономії, коли запис знаходиться в декількох елементах однієї таксономії одночасно.
																		// Наприклад: array( 'category' => array( 45, 'term_name' ), 'tax_name' => array( 1, 2, 'name' ) )
																		// 'category' - таксономія, для якої вказуються пріоритетні елементи: 45 - ID терміна та 'term_name' - ярлик.
																		// порядок 45 и 'term_name' має значення: що раніше тим важливіше. Усі зазначені терміни важливіші за невказані.
			'nofollow'        => false, // Додавати rel=nofollow до посилань?

			// службові
			'sep'             => '',
			'linkpatt'        => '',
			'pg_end'          => '',
		);


		/**
		 * Виводить на екран хлібні крихти
		 *
		 * @param  string [$sep  = '']      Розділювач. За замовчуванням ''
		 * @param  array  [$l10n = array()] Для локалізації. Див. змінну $default_l10n.
		 * @param  array  [$args = array()] Опції. Див. змінну $def_args
		 * @return void                     Виводить на екран HTML код
		 */
		function get_crumbs( $sep, $l10n, $args ) {
			global $post, $wp_query, $wp_post_types;

			self::$args['sep'] = $sep;

			// Фільтрує дефолти та зливає
			$loc = (object) array_merge( apply_filters( 'kama_breadcrumbs_default_loc', self::$l10n ), $l10n );
			$arg = (object) array_merge( apply_filters( 'kama_breadcrumbs_default_args', self::$args ), $args );

			$arg->sep = ( $arg->sep ) ? '<span class="b-breadcrumbs__sep">' . $arg->sep . '</span>' : ''; // доповнимо

			// спростимо
			$sep = & $arg->sep;
			$this->arg = & $arg;

			// мікророзмітка
			if ( 1 ) {
				$mark = $arg->markup;

				if ( ! $mark ) {
					// Розмітка за замовчуванням
					$mark = array(
						'wrappatt'  => '<div class="l-breadcrumbs"><ul class="b-breadcrumbs">%s</ul></div>',
						'linkpatt'  => '<li class="b-breadcrumbs__item"><a class="b-breadcrumbs__link" href="%s">%s</a>',
						'sep_after' => '</li>',
					);
				} elseif ( $mark === 'rdf.data-vocabulary.org' ) {
					// rdf
					$mark = array(
						'wrappatt'   => '<div class="l-breadcrumbs"><ul class="b-breadcrumbs" prefix="v: http://rdf.data-vocabulary.org/#">%s</ul></div>',
						'linkpatt'   => '<li class="b-breadcrumbs__item" typeof="v:Breadcrumb"><a class="b-breadcrumbs__link" href="%s" rel="v:url" property="v:title">%s</a>',
						'sep_after'  => '</li>', // закриваємо li після роздільника!
					);
				} elseif ( $mark === 'schema.org' ) {
					// schema.org
					$mark = array(
						'wrappatt'   => '<div class="l-breadcrumbs"><ul class="b-breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">%s</ul></div>',
						'linkpatt'   => '<li class="b-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="b-breadcrumbs__link" href="%s" itemprop="item"><span class="b-breadcrumbs__name" itemprop="name">%s</span></a>',
						'sep_after'  => '</li>',
					);
				} elseif ( $mark === 'ld+json' ) {
					// ld+json
					$mark = array(
						'wrappatt'   => '<script type="application/ld+json">{"@context": "https://schema.org", "@type": "BreadcrumbList", "itemListElement": [ %s ]}</script>',
						'linkpatt'   => '{ "@type": "ListItem", "item": "%s", "name": "%s"',
						'sep_after'  => '}, ',
					);
				} elseif ( ! is_array( $mark ) ) {
					die( __CLASS__ . ': "markup" parameter must be array…');
				}

				// якщо це ld+json, примусово замінимо шаблон для останнього заголовка
				if ( 'ld+json' == $arg->markup ) {
					$arg->show_post_title = true;
					$arg->show_term_title = true;
					$arg->title_patt      = '{ "@type": "ListItem", "name": "%s" }';
				}

				$wrappatt  = $mark['wrappatt'];
				$arg->linkpatt  = $arg->nofollow ? str_replace( '<a ', '<a rel="nofollow"', $mark['linkpatt'] ) : $mark['linkpatt'];
				$arg->sep      .= $mark['sep_after'];
			}

			$linkpatt = $arg->linkpatt; // спростимо

			$queried_object = get_queried_object();

			// може це архів порожньої такси?
			$ptype = null;
			if ( empty( $post ) ) {
				if ( isset( $queried_object->taxonomy ) ) {
					$ptype = & $wp_post_types[ get_taxonomy( $queried_object->taxonomy )->object_type[0] ];
				}
			} else {
				$ptype = & $wp_post_types[ $post->post_type ];
			}

			// paged & custom search
			$arg->pg_end = '';
			if ( ( $paged_num = get_query_var( 'paged' ) ) || ( $paged_num = get_query_var( 'page' ) ) ) {
				$arg->pg_end = $sep . sprintf( $arg->title_patt, sprintf( $loc->paged, (int) $paged_num ) );
			} elseif ( get_query_var( 'search' ) ) {
				$arg->pg_end = $sep . sprintf( $arg->title_patt, sprintf( $loc->search, esc_html( get_query_var( 'search' ) ) ) );
			}

			$pg_end = $arg->pg_end; // спростимо

			// ну, з богом…
			$out = '';

			if ( is_front_page() ) {
				return $arg->on_front_page ? sprintf( $wrappatt, ( $paged_num ? sprintf( $linkpatt, get_home_url(), $loc->home ) . $pg_end : $loc->home ) ) : '';
			} elseif ( is_home() ) {
				// сторінка записів, коли для головної встановлено окрему сторінку
				$out = $paged_num ? ( sprintf( $linkpatt, get_permalink( $queried_object ), esc_html( $queried_object->post_title ) ) . $pg_end ) : esc_html( $queried_object->post_title );
				$out = sprintf( $arg->title_patt, $out );
			} elseif ( is_404() ) {
				$out = $loc->_404;
				$out = sprintf( $arg->title_patt, $out );
			} elseif ( is_search() ) {
				$out = sprintf( $loc->search, esc_html( $GLOBALS['s'] ) );
				$out = sprintf( $arg->title_patt, $out );
			} elseif ( is_author() ) {
				$tit = sprintf( $loc->author, esc_html( $queried_object->display_name ) );
				$out = ( $paged_num ? sprintf( $linkpatt, get_author_posts_url( $queried_object->ID, $queried_object->user_nicename ) . $pg_end, $tit ) : $tit );
				$out = sprintf( $arg->title_patt, $out );
			} elseif ( is_year() || is_month() || is_day() ) {
				$y_url = get_year_link( $year = get_the_time( 'Y' ) );

				if ( is_year() ) {
					$tit = sprintf( $loc->year, $year );
					$out = ( $paged_num ? sprintf( $linkpatt, $y_url, $tit ) . $pg_end : $tit );
					$out = sprintf( $arg->title_patt, $out );
				} else {
					// month/day
					$y_link = sprintf( $linkpatt, $y_url, $year);
					$m_url  = get_month_link( $year, get_the_time( 'm' ) );

					if ( is_month() ) {
						$tit = sprintf( $loc->month, get_the_time( 'F' ) );
						$out = $y_link . $sep . ( $paged_num ? sprintf( $linkpatt, $m_url, $tit ) . $pg_end : $tit );
						$out = sprintf( $arg->title_patt, $out );
					} elseif ( is_day() ) {
						$m_link = sprintf( $linkpatt, $m_url, get_the_time( 'F' ) );
						$out = $y_link . $sep . $m_link . $sep . get_the_time( 'l' );
						$out = sprintf( $arg->title_patt, $out );
					}
				}
			} elseif ( is_singular() && $ptype->hierarchical ) {
				// Деревоподібні записи
				$out = $this->_add_title( $this->_page_crumbs( $post ), $post );
			} else {
				// Таксономії, плоскі записи та вкладення
				$term = $queried_object; // таксономії

				// визначаємо термін для записів (включаючи вкладення attachments)
				if ( is_singular() ) {
					// змінимо $post, щоб визначити термін батька вкладення
					if ( is_attachment() && $post->post_parent ) {
						$save_post = $post; // сохраним
						$post = get_post( $post->post_parent );
					}

					// враховує якщо вкладення прикріплюються до деревоподібних - все буває :)
					$taxonomies = get_object_taxonomies( $post->post_type );
					// залишимо лише деревоподібні та публічні, про всяк випадок…
					$taxonomies = array_intersect( $taxonomies, get_taxonomies( array( 'hierarchical' => true, 'public' => true, 'publicly_queryable' => true ) ) );

					if ( $taxonomies ) {
						// сортуємо за пріоритетом
						if ( ! empty( $arg->priority_tax ) ) {
							usort( $taxonomies, function( $a, $b ) use( $arg ) {
								$a_index = array_search( $a, $arg->priority_tax );
								if ( $a_index === false ) $a_index = 9999999;

								$b_index = array_search( $b, $arg->priority_tax );
								if ( $b_index === false ) $b_index = 9999999;

								return ( $b_index === $a_index ) ? 0 : ( $b_index < $a_index ? 1 : -1 ); // менше індекс - вище
							} );
						}

						// пробуємо отримати терміни, в порядку пріоритету таксономій
						foreach ( $taxonomies as $taxname ) {
							if ( $terms = get_the_terms( $post->ID, $taxname ) ) {
								// перевіримо пріоритетні терміни для таксономії
								$prior_terms = & $arg->priority_terms[ $taxname ];

								if ( $prior_terms && count( $terms ) > 2 ) {
									foreach ( (array) $prior_terms as $term_id ) {
										$filter_field = is_numeric( $term_id ) ? 'term_id' : 'slug';
										$_terms = wp_list_filter( $terms, array( $filter_field => $term_id ) );

										if ( $_terms ) {
											$term = array_shift( $_terms );
											break;
										}
									}
								} else {
									$term = array_shift( $terms );
								}

								break;
							}
						}
					}

					if ( isset( $save_post ) ) $post = $save_post; // повернемо назад (для вкладень)
				}

				// виведення

				// всі види записів з термінами чи терміни
				if ( $term && isset( $term->term_id ) ) {
					$term = apply_filters( 'kama_breadcrumbs_term', $term );

					if ( is_attachment() ) {
						// attachment
						if ( ! $post->post_parent ) {
							$out = sprintf( $loc->attachment, esc_html( $post->post_title ) );
						} else {
							if ( ! $out = apply_filters( 'attachment_tax_crumbs', '', $term, $this ) ) {
								$_crumbs    = $this->_tax_crumbs( $term, 'self' );
								$parent_tit = sprintf( $linkpatt, get_permalink( $post->post_parent ), get_the_title( $post->post_parent ) );
								$_out = implode( $sep, array( $_crumbs, $parent_tit ) );
								$out = $this->_add_title( $_out, $post );
							}
						}
					} elseif ( is_single() ) {
						// single
						if ( ! $out = apply_filters( 'post_tax_crumbs', '', $term, $this ) ) {
							$_crumbs = $this->_tax_crumbs( $term, 'self' );
							$out = $this->_add_title( $_crumbs, $post );
						}
					} elseif ( ! is_taxonomy_hierarchical( $term->taxonomy ) ) {
						// не деревоподібна таксономія (теги)
						if ( is_tag() ) {
							// тег
							$out = $this->_add_title('', $term, sprintf( $loc->tag, esc_html( $term->name ) ) );
						} elseif ( is_tax() ) {
							// таксономія
							$post_label = $ptype->labels->name;
							$tax_label = $GLOBALS['wp_taxonomies'][ $term->taxonomy ]->labels->name;
							$out = $this->_add_title( '', $term, sprintf( $loc->tax_tag, $post_label, $tax_label, esc_html( $term->name ) ) );
						}
					} else {
						// деревоподібна таксономія (рубрики)
						if ( ! $out = apply_filters( 'term_tax_crumbs', '', $term, $this ) ) {
							$_crumbs = $this->_tax_crumbs( $term, 'parent' );
							$out = $this->_add_title( $_crumbs, $term, esc_html( $term->name ) );
						}
					}
				} elseif ( is_attachment() ) {
					// вкладення від запису без термінів
					$parent = get_post( $post->post_parent );
					$parent_link = sprintf( $linkpatt, get_permalink( $parent ), esc_html( $parent->post_title ) );
					$_out = $parent_link;

					if ( is_post_type_hierarchical( $parent->post_type ) ) {
						// вкладення від запису деревоподібного типу запису
						$parent_crumbs = $this->_page_crumbs( $parent );
						$_out = implode( $sep, array( $parent_crumbs, $parent_link ) );
					}

					$out = $this->_add_title( $_out, $post );
				} elseif ( is_singular() ) {
					// записи без термінів
					$out = $this->_add_title( '', $post );
				}
			}

			// заміна посилання на архівну сторінку для типу запису
			$home_after = apply_filters( 'kama_breadcrumbs_home_after', '', $linkpatt, $sep, $ptype );

			if ( '' === $home_after ) {
				// Посилання на архівну сторінку типу запису для окремих сторінок цього типу; архівів цього; таксономій пов'язаних із цим типом.
				if ( $ptype && $ptype->has_archive && ! in_array( $ptype->name, array( 'post', 'page', 'attachment' ) ) && ( is_post_type_archive() || is_singular() || (is_tax() && in_array( $term->taxonomy, $ptype->taxonomies ) ) ) ) {
					$pt_title = $ptype->labels->name;

					if ( is_post_type_archive() && ! $paged_num ) {
						// перша сторінка архіву типу запису
						$home_after = sprintf( $arg->title_patt, $pt_title );
					} else {
						// singular, paged post_type_archive, tax
						$home_after = sprintf( $linkpatt, get_post_type_archive_link( $ptype->name ), $pt_title );
						$home_after .= ( ( $paged_num && ! is_tax() ) ? $pg_end : $sep ); // пагінація
					}
				}
			}

			$before_out = sprintf( $linkpatt, home_url(), $loc->home ) . ( $home_after ? $sep . $home_after : ( $out ? $sep : '' ) );

			$out = apply_filters( 'kama_breadcrumbs_pre_out', $out, $sep, $loc, $arg );

			$out = sprintf( $wrappatt, $before_out . $out );

			return apply_filters( 'kama_breadcrumbs', $out, $sep, $loc, $arg );
		}


		/**
		 * [_page_crumbs description]
		 *
		 * @param  [type] $post [description]
		 * @return [type]       [description]
		 */
		function _page_crumbs( $post ) {
			$parent = $post->post_parent;

			$crumbs = array();
			while ( $parent ) {
				$page = get_post( $parent );
				$crumbs[] = sprintf( $this->arg->linkpatt, get_permalink( $page ), esc_html( $page->post_title ) );
				$parent = $page->post_parent;
			}

			return implode( $this->arg->sep, array_reverse( $crumbs ) );
		}


		/**
		 * [_tax_crumbs description]
		 *
		 * @param  [type] $term       [description]
		 * @param  string $start_from [description]
		 * @return [type]             [description]
		 */
		function _tax_crumbs( $term, $start_from = 'self' ) {
			$termlinks = array();
			$term_id = ( $start_from === 'parent' ) ? $term->parent : $term->term_id;

			while ( $term_id ) {
				$term        = get_term( $term_id, $term->taxonomy );
				$termlinks[] = sprintf( $this->arg->linkpatt, get_term_link( $term ), esc_html( $term->name ) );
				$term_id     = $term->parent;
			}

			if ( $termlinks ) {
				return implode( $this->arg->sep, array_reverse( $termlinks ) ) /*. $this->arg->sep*/;
			}

			return '';
		}


		/**
		 * Додає заголовок до переданого тексту з урахуванням усіх опцій. Додає роздільник на початок, якщо треба.
		 *
		 * @param [type] $add_to     [description]
		 * @param [type] $obj        [description]
		 * @param string $term_title [description]
		 */
		function _add_title( $add_to, $obj, $term_title = '' ) {
			$arg = & $this->arg; // спростимо…
			$title = $term_title ? $term_title : esc_html( $obj->post_title ); // $term_title очищується окремо, теги можуть бути…
			$show_title = $term_title ? $arg->show_term_title : $arg->show_post_title;

			if ( $arg->pg_end ) {
				// пагінація чи кастомний пошук
				$link = $term_title ? get_term_link( $obj ) : get_permalink( $obj );
				$add_to .= ( $add_to ? $arg->sep : '' ) . sprintf( $arg->linkpatt, $link, $title ) . $arg->pg_end;
			} elseif ( $add_to ) {
				// доповнюємо - ставимо sep
				if ( $show_title ) {
					$add_to .= $arg->sep . sprintf( $arg->title_patt, $title );
				} elseif ( $arg->last_sep ) {
					$add_to .= $arg->sep;
				}
			} elseif ( $show_title ) {
				// sep буде потім…
				$add_to = sprintf( $arg->title_patt, $title );
			}

			return $add_to;
		}

	}
}
