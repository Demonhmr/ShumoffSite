<?php
/**
 * Archive template for services CPT.
 *
 * @package Shumoff_Theme
 */

get_header();
?>

<section class="archive-section section section--dark">
	<div class="container">
		<h1 class="section-title text-center"><?php _e( 'Услуги', 'shumoff' ); ?></h1>
		<p class="section-subtitle text-center">
			<?php
			if ( is_tax( 'case_type' ) ) :
				$term = get_queried_object();
				if ( $term ) :
					printf( __( 'Услуги категории: %s', 'shumoff' ), esc_html( $term->name ) );
				else :
					the_archive_title();
				endif;
			else :
				_e( 'Полный спектр услуг по шумоизоляции автомобилей', 'shumoff' );
			endif;
			?>
		</p>
	</div>
</section>

<section class="archive-services section">
	<div class="container">
		<div class="services-grid">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					$price_from = shumoff_field( 'service_price_from' );
					$duration   = shumoff_field( 'service_duration' );
					?>

					<article class="service-card hover-lift">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="service-card__image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'shumoff-thumbnail' ); ?>
								</a>
							</div>
						<?php endif; ?>

						<div class="service-card__content">
							<h3 class="service-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>

							<p class="service-card__excerpt">
								<?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
							</p>

							<?php if ( $price_from ) : ?>
								<div class="service-card__price">
									<span class="price-label"><?php _e( 'Цена от:', 'shumoff' ); ?></span>
									<span class="price-value"><?php echo esc_html( $price_from ); ?> ₽</span>
								</div>
							<?php endif; ?>

							<?php if ( $duration ) : ?>
								<div class="service-card__duration">
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:4px"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
									<?php echo esc_html( $duration ); ?>
								</div>
							<?php endif; ?>

							<a href="<?php the_permalink(); ?>" class="btn btn-outline btn--sm"><?php _e( 'Подробнее', 'shumoff' ); ?></a>
						</div>
					</article>

					<?php
				endwhile;

				the_posts_pagination( array(
					'mid_size'  => 2,
					'prev_text' => '&laquo; ' . __( 'Назад', 'shumoff' ),
					'next_text' => __( 'Вперёд', 'shumoff' ) . ' &raquo;',
				) );

			else :
				?>
				<p class="text-center"><?php _e( 'Услуги пока не добавлены.', 'shumoff' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
