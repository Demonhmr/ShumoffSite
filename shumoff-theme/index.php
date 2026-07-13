<?php
/**
 * Fallback-шаблон для всего, у чего нет собственного шаблона:
 * блог, таксономии car_brand / case_type и т.п.
 *
 * @package Shumoff_Theme
 */

get_header();
?>

<main class="page-content">
	<section class="archive-section section section--dark">
		<div class="container">
			<h1 class="section-title text-center">
				<?php
				if ( is_home() ) {
					_e( 'Блог', 'shumoff' );
				} else {
					the_archive_title();
				}
				?>
			</h1>
			<?php if ( get_the_archive_description() ) : ?>
				<p class="section-subtitle text-center"><?php echo wp_kses_post( get_the_archive_description() ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<?php if ( have_posts() ) : ?>
				<div class="cases-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'case-card hover-lift' ); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="case-card__image">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'shumoff-thumbnail' ); ?>
									</a>
								</div>
							<?php endif; ?>
							<div class="case-card__body">
								<h2 class="case-card__title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h2>
								<p class="case-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
								<a href="<?php the_permalink(); ?>" class="case-card__link"><?php _e( 'Читать далее →', 'shumoff' ); ?></a>
							</div>
						</article>
					<?php endwhile; ?>
				</div>

				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 2,
						'prev_text' => '&laquo; ' . __( 'Назад', 'shumoff' ),
						'next_text' => __( 'Вперёд', 'shumoff' ) . ' &raquo;',
					)
				);
				?>
			<?php else : ?>
				<p class="text-center"><?php _e( 'Записей пока нет.', 'shumoff' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
