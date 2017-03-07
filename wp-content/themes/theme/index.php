<?php get_header(); ?>

<main class="l-contentText" role="main">

  <?php while ( have_posts() ) : the_post(); ?>
    <section class="b-contentText">
      <h2 class="b-contentText__title"><?php the_title(); ?></h2>
      <div class="b-contentText__content b-text"><?php the_content(); ?></div>
    </section>
  <?php endwhile; ?>

  <?php nc_pagenavi(); ?>

</main>

<?php get_footer(); ?>
