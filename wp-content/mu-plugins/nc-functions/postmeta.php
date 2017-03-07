<?php
/**
 * Prefix for post_meta
 */
function nc_get_prefix() {
  $prefix = '_nc_';
  return $prefix;
}


/**
 * Получаем значение метаполя, если передаем конкретный ключ
 * Получаем массив всех метаполей поста, если ключ не передаем
 *
 * Если функцию вызываем в цикле WP, $post_id не передаем
 *
 * @params [int $post_id] [array $keys]
 * @returns array, string, false, null
 */
function nc_get_post_meta( $post_id = 0, $keys = array() ) {
  $nc_prefix = nc_get_prefix();

  // Если $post_id  не было передано, получаем его внутри цикла WP
  // $post_id = 0 ? get_the_ID() : absint($post_id);

  // Если $post_id не удалось получить
  if ( ! $post_id ) {
    return 'No post id';
  }

  $meta = array();

  // Если $keys - массив значений
  if ( is_array( $keys ) ) {
    foreach ( $keys as $key ) {
      $key = sanitize_key( $key );
      $meta[$key] = get_post_meta( $post_id, $nc_prefix . $key, true );
    }
  } else {
    $meta[$keys] = get_post_meta( $post_id, $nc_prefix . $keys, true );
  }

  return $meta;
}
?>
