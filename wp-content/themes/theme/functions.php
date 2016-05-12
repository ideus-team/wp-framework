<?php
// Content Width (http://codex.wordpress.org/Content_Width)
if (!isset($content_width)) {
	$content_width = 500;
}

add_action('after_setup_theme', 'nc_setup');
function nc_setup() {
  remove_action('wp_head', 'wp_generator');
  //remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  //remove_action('wp_head', 'index_rel_link');
  //remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  //remove_action('wp_head', 'start_post_rel_link', 10, 0);
  //remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  //remove_action('wp_head', 'rel_canonical');

  // This feature enables plugins and themes to manage the document title tag. This should be used in place of wp_title() function.
  add_theme_support('title-tag');

  // This feature allows the use of HTML5 markup for the search forms, comment forms, comment lists, gallery, and caption.
  add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

  // This feature enables Post Thumbnails support for a Theme.
  add_theme_support('post-thumbnails', array('post', 'page'));

  // This feature enables Post Formats support for a Theme.
  //add_theme_support('post-formats', array('aside', 'gallery'));

  // Styles for editor
  add_editor_style('assets/css/editor-style.min.css');

  // Navigation
  register_nav_menus(array(
    'header'  => 'Navigation Top Menu',
    'footer'  => 'Navigation Bottom Menu'
  ));
}

// Styles
add_action('wp_enqueue_scripts', 'nc_styles');
function nc_styles() {
  $protocol = is_ssl() ? 'https' : 'http';
  //wp_enqueue_style('googlefonts', $protocol.'://fonts.googleapis.com/css?family=Lato:100,300,400,600,700,900|Open+Sans:400,300,600,700,800|');
  wp_enqueue_style('css-main', get_template_directory_uri().'/assets/css/main.min.css', false, filemtime(get_template_directory().'/assets/css/main.min.css'));
}

// Scripts
add_action('wp_enqueue_scripts', 'nc_scripts');
function nc_scripts() {
  wp_deregister_script('jquery');
  wp_register_script('jquery', get_template_directory_uri().'/assets/js/vendor/jquery-2.2.3.min.js', false, '2.2.3');

  wp_enqueue_script('jquery');
  wp_enqueue_script('js-main', get_template_directory_uri().'/assets/js/scripts.js', array('jquery'), filemtime(get_template_directory().'/assets/js/scripts.js'), true);
  // wp_enqueue_script('js-extra', get_template_directory_uri().'/assets/js/scripts-extra.js', array('jquery'), filemtime(get_template_directory().'/assets/js/scripts-extra.js'), true);

  // Variables for JS (ncVar.ajaxurl & ncVar.themeurl)
  wp_localize_script('js-main', 'ncVar', array(
    'ajaxurl'  => admin_url('admin-ajax.php'),
    'themeurl' => get_template_directory_uri(),
  ));
}


// Modify except
function nc_excerpt($num_words = 25, $more = '… →') {
  $excerpt = wp_trim_words(get_the_excerpt(), $num_words, $more);
  echo apply_filters('the_excerpt', $excerpt);
}

add_filter('excerpt_more', 'nc_excerpt_more');
function nc_excerpt_more($more) {
  return '…';
}

add_filter('excerpt_length', 'nc_excerpt_length');
function nc_excerpt_length($length) {
  return 20;
}

function nc_tel($phone = '') {
  $patterns[0] = '/\ /';
  $patterns[1] = '/\./';
  $patterns[2] = '/\(/';
  $patterns[3] = '/\)/';
  $patterns[4] = '/\-/';

  return preg_replace($patterns, '', $phone);
}
?>