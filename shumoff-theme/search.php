<?php
/**
 * Shumoff Theme - Search Template
 *
 * @package Shumoff_Theme
 */

get_header();
?>

<section class="search-section section section--dark">
    <div class="container">
        <h1 class="section-title text-center">Результаты поиска</h1>
        <p class="section-subtitle text-center">
            <?php
            $search_term = get_search_query();
            printf(
                esc_html__( 'Поиск по запросу: "%s"', 'shumoff' ),
                esc_html( $search_term )
            );
            ?>
        </p>
    </div>
</section>

<section class="search-results section">
    <div class="container">
        <?php if ( have_posts() ) : ?>
        <div class="search-results-list">
            <?php while ( have_posts() ) : the_post(); ?>
            <article class="search-result-item">
                <h3 class="search-result-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
                <p class="search-result-excerpt"><?php the_excerpt(); ?></p>
                <span class="search-result-date"><?php echo get_the_date(); ?></span>
                <span class="search-result-type">
                    <?php echo get_post_type_object( get_post_type() )->labels->name; ?>
                </span>
            </article>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="search-pagination">
            <?php
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => '← Назад',
                'next_text' => 'Вперёд →',
            ) );
            ?>
        </div>
        <?php else : ?>
        <div class="search-no-results text-center">
            <p>По вашему запросу ничего не найдено.</p>
            <p>Попробуйте изменить поисковый запрос или перейдите на:</p>
            <div class="search-no-results-links">
                <a href="<?php echo esc_url( home_url( '/services' ) ); ?>">Услуги</a>
                <a href="<?php echo esc_url( home_url( '/cases' ) ); ?>">Кейсы</a>
                <a href="<?php echo esc_url( home_url( '/cars' ) ); ?>">Автомобили</a>
                <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>">Блог</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer();
?>
