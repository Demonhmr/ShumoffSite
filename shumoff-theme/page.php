<?php
/**
 * Shumoff Theme - Page Template
 * Шаблон для обычных страниц
 *
 * @package Shumoff_Theme
 */

get_header();
?>

<section class="page-hero section section--dark">
    <div class="container">
        <h1 class="section-title text-center"><?php the_title(); ?></h1>
    </div>
</section>

<section class="page-content section">
    <div class="container">
        <div class="page-content-inner">
            <?php
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>
</section>

<?php
get_footer();
?>
