<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * @link     https://github.com/WebDevStudios/CMB2
 */
if ( file_exists( WPMU_PLUGIN_DIR . '/nc-lib/CMB2/init.php' ) ) {
  require_once WPMU_PLUGIN_DIR . '/nc-lib/CMB2/init.php';
}


/*
// More examples in nc-lib/CMB2/example-functions.php
add_action( 'cmb2_init', 'nc_metabox_demo' );
function nc_metabox_demo() {
  $prefix = nc_get_prefix();

  $cmb = new_cmb2_box( array(
    'id'            => $prefix . 'metabox_demo',
    'title'         => 'Test Metabox',
    'object_types'  => array( 'page', ), // Post type
    // 'show_on'    => array( 'id' => array( 2, ) ), // Specific post IDs to display this metabox
    // 'context'    => 'normal',
    // 'priority'   => 'high',
    // 'show_names' => true, // Show field names on the left
    // 'cmb_styles' => false, // false to disable the CMB stylesheet
    // 'closed'     => true, // true to keep the metabox closed by default
  ) );

  $cmb->add_field( array(
    'name' => 'Text 1',
    'desc' => 'field description (optional)',
    'id'   => $prefix . 'text1',
    'type' => 'text',
  ) );

  $cmb->add_field( array(
    'name' => 'Text 2',
    'desc' => 'field description (optional)',
    'id'   => $prefix . 'text2',
    'type' => 'text',
  ) );

  $cmb_group = $cmb->add_field( array(
    'name'        => 'Links',
    'id'          => $prefix . 'group',
    'type'        => 'group',
    'description' => '',
    'options'     => array(
			'group_title'   => __( 'Entry {#}', 'cmb2' ),
			'add_button'    => __( 'Add Another Entry', 'cmb2' ),
			'remove_button' => __( 'Remove Entry', 'cmb2' ),
      'sortable'      => true,
    ),
  ) );

  $cmb->add_group_field( $cmb_group, array(
    'name' => 'Text',
    'desc' => '',
    'id'   => 'text',
    'type' => 'text',
  ) );
}
*/

/**
 * Gets a number of terms and displays them as options
 * @param  string       $taxonomy Taxonomy terms to retrieve. Default is category.
 * @param  string|array $args     Optional. get_terms optional arguments
 * @return array                  An array of options that matches the CMB2 options array
 */
function cmb2_get_term_options( $args = array() ) {
  $args = wp_parse_args( $args, array(
    'taxonomy'   => 'category',
    'hide_empty' => false,
  ) );

  $taxonomy = $args['taxonomy'];

  $terms = (array) get_terms( $taxonomy, $args );

  // Initate an empty array
  $term_options = array();

  if ( ! empty( $terms ) ) {
    foreach ( $terms as $term ) {
      $term_options[ $term->term_id ] = $term->name;
    }
  }

  return $term_options;
}


/**
 * Gets a number of posts and displays them as options
 * @param  array $query_args Optional. Overrides defaults.
 * @return array             An array of options that matches the CMB2 options array
 */
function cmb2_get_post_options( $query_args ) {
  $args = wp_parse_args( $query_args, array(
    'post_type'   => 'post',
    'numberposts' => -1,
    'orderby'     => 'name',
    'order'       => 'ASC',
  ) );

  $posts = get_posts( $args );

  // Initate an empty array
  $post_options = array();

  if ( $posts ) {
    foreach ( $posts as $post ) {
      $post_options[ $post->ID ] = $post->post_title;
    }
  }

  return $post_options;
}
