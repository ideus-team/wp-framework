<?php
/**
 * Template Name: Example
 * Template Post Type: page
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

  <main class="l-contentText">

    <?php nc_breadcrumbs(); ?>

    <section class="b-contentText">
      <h2 class="b-contentText__title"><?php the_title(); ?></h2>
      <div class="b-contentText__content b-text">
        <h1>Suspendisse vitae velit in lacus porttitor accumsan.</h1>
        <h2>Donec pretium elit vel felis blandit rutrum.</h2>
        <h3>Aenean facilisis libero ut semper consectetur.</h3>
        <h4>Vestibulum fringilla quam vel risus sollicitudin convallis.</h4>
        <h5>In feugiat sapien sed quam fermentum, quis auctor lectus pretium.</h5>
        <h6>Nullam bibendum magna in nunc tincidunt tincidunt.</h6>

        <p>Pellentesque non rutrum nibh. Duis auctor magna vitae elit hendrerit fringilla. Curabitur sodales bibendum lacus, eu suscipit arcu auctor sed. Suspendisse imperdiet orci vitae nunc viverra, sit amet mollis magna tristique. Vivamus at facilisis odio. Mauris finibus ex lacus, et commodo sem egestas et. Nullam eget posuere enim, placerat iaculis ipsum. Etiam aliquam sit amet mauris a convallis. Vestibulum in eros lacus. Sed facilisis leo id ullamcorper eleifend.</p>

        <p><img class="alignleft size-full" src="https://fakeimg.pl/440x230/282828/eae0d0/?text=Image" width="440" height="230" />In non posuere purus. Vivamus a malesuada dui. Vestibulum suscipit finibus ex eget euismod. Curabitur aliquam efficitur sem vel facilisis. Sed malesuada interdum blandit. Etiam id cursus velit. Integer quam sapien, porta bibendum viverra in, congue sit amet felis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed fermentum quam id diam volutpat, eu finibus magna pharetra. Pellentesque laoreet metus ipsum. Donec ut lectus feugiat lorem eleifend venenatis. Fusce sollicitudin ultricies arcu, nec dapibus arcu. Vestibulum massa sapien, hendrerit at diam a, porta imperdiet arcu. In nec nunc tempor, malesuada tellus in, vestibulum ligula. Duis eu tincidunt quam.</p>

        <p>Phasellus nisl ligula, tincidunt sed tincidunt a, tempus nec enim. Duis dapibus aliquet nisl, eget imperdiet mauris fringilla sed. Donec arcu sapien, dignissim quis ipsum id, mattis condimentum dui. Pellentesque nec vehicula dui. Sed fringilla mattis metus, eget ullamcorper quam bibendum ac. Proin sit amet dolor orci. Phasellus nec mollis purus. Donec congue dignissim erat, vitae dapibus dui gravida vel. Morbi dapibus dui at bibendum ultrices. Cras maximus vestibulum neque in viverra.</p>

        <p><img class="alignright size-full" src="https://fakeimg.pl/440x230/282828/eae0d0/?text=Image" width="440" height="230" />Aliquam ac nulla iaculis, viverra eros feugiat, ullamcorper magna. Aliquam at volutpat eros. Praesent quis consequat nisl. Mauris risus purus, ultrices ac lacus vitae, imperdiet consectetur sem. Nunc et leo tristique, finibus felis eget, maximus lacus. Donec quis consequat risus. Etiam dolor velit, convallis ut odio finibus, scelerisque semper neque. Nunc ornare eros vel purus fringilla, sit amet bibendum nibh tempus. Sed lacinia augue at est commodo, non pellentesque dolor varius. Integer magna mauris, tempor ut aliquam ac, iaculis vel risus. Nam condimentum elit eget tellus dictum, a ultrices metus aliquet. Mauris sollicitudin ornare mi, vitae blandit erat dapibus auctor. Duis et risus in lacus hendrerit auctor. Fusce sit amet iaculis lacus. Duis eleifend fermentum urna id tempor.</p>

        <p>In vitae arcu quis justo ullamcorper hendrerit id eget elit. Nam est ligula, cursus feugiat vulputate non, ultricies non leo. Etiam ac mauris ultricies, viverra dolor vel, pellentesque ligula. Proin eleifend purus nibh. Vivamus in dui sit amet eros tempor tincidunt. Morbi eleifend non turpis luctus condimentum. Mauris dictum risus non condimentum finibus. Nulla non hendrerit mi. Maecenas consequat tempor sem. Cras scelerisque iaculis laoreet. Suspendisse tincidunt magna eu orci posuere, non iaculis ex pretium. Aliquam id faucibus eros, tristique dignissim ex.</p>

        <ul>
          <li>Proin vitae metus et dolor consectetur sagittis.</li>
          <li>Quisque vel sem nec ipsum iaculis varius.</li>
          <li>Sed et ex lobortis, consequat ligula eu, finibus eros.</li>
        </ul>

        <ol>
          <li>Vestibulum eu enim et ipsum maximus dignissim pellentesque ut tortor.</li>
          <li>Maecenas lacinia lectus tincidunt neque lacinia, ac maximus felis faucibus.</li>
          <li>Curabitur et elit ultrices, sagittis erat vitae, dignissim lorem.</li>
        </ol>

        <blockquote>Sed ut mauris id dui ornare tempor aliquet id tortor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eu massa felis. Aenean nec massa nec ipsum rhoncus sagittis. Ut eu vestibulum felis. Suspendisse quis faucibus mauris, euismod sagittis magna. Nunc sit amet accumsan leo, ac imperdiet enim. Sed a metus hendrerit, euismod quam id, malesuada arcu. In hac habitasse platea dictumst. Fusce sed gravida leo. Donec quis felis id diam iaculis vestibulum. Proin et porta ante. Donec ornare porttitor lectus dapibus bibendum. Mauris fermentum in urna in dignissim. Vivamus at tristique elit, non mattis nisi.</blockquote>

        <code>Sed non congue ante. Duis eu augue id enim porta ultrices sed eget mi. In hac habitasse platea dictumst. Duis sodales elit id tempor faucibus. Pellentesque pellentesque varius dolor non porta. Mauris a massa venenatis, interdum purus vel, vehicula orci. Mauris vulputate massa sit amet nunc dignissim, ac vulputate ex aliquam. Integer sem felis, faucibus venenatis porttitor in, vulputate eget odio. Sed volutpat enim sed erat maximus, sed malesuada mauris interdum. In porta risus eget lacinia tristique. Donec et nisi eu eros dignissim aliquam. Donec euismod egestas dolor, id accumsan enim tempus sed. Vivamus egestas magna id condimentum porttitor.</code>
      </div>
    </section>

  </main>

<?php endwhile; ?>

<?php get_footer(); ?>
