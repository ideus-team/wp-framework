<?php
/*
Template Name: Template Example
Template Post Type: page
*/

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

  <main class="l-contentText">

    <?php nc_breadcrumbs(); ?>

    <section class="b-contentText">
      <h2 class="b-contentText__title"><?php the_title(); ?></h2>
      <div class="b-contentText__content b-text"><?php the_content(); ?></div>
    </section>

  </main>

<?php endwhile; ?>

<?php get_footer(); ?>
