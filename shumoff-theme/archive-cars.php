<?php
/**
 * Archive template for cars CPT.
 *
 * @package Shumoff_Theme
 */

get_header();
?>

<section class="archive-section section section--dark">
	<div class="container">
		<h1 class="section-title text-center"><?php _e( 'Автомобили', 'shumoff' ); ?></h1>
		<p class="section-subtitle text-center">
			<?php
			if ( is_tax( 'car_brand' ) ) :
				$term = get_queried_object();
				if ( $term ) :
					printf( __( 'Автомобили марки: %s', 'shumoff' ), esc_html( $term->name ) );
				else :
					the_archive_title();
				endif;
			else :
				_e( 'Шумоизоляция для любых марок и моделей автомобилей', 'shumoff' );
			endif;
			?>
		</p>
	</div>
</section>

<section class="archive-cars section">
	<div class="container">
		<div class="cars-grid">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					$full_price = shumoff_field( 'car_full_price' );
					$car_class  = shumoff_field( 'car_class' );
					?>

					<article class="car-card hover-lift">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="car-card__image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'shumoff-thumbnail' ); ?>
								</a>
							</div>
						<?php endif; ?>

						<div class="car-card__content">
							<h3 class="car-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>

							<?php if ( $car_class ) : ?>
								<p class="car-card__class">
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:4px"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
									<?php echo esc_html( $car_class ); ?>
								</p>
							<?php endif; ?>

							<?php if ( $full_price ) : ?>
								<div class="car-card__price">
									<span class="price-label"><?php _e( 'Полная шумоизоляция от:', 'shumoff' ); ?></span>
									<span class="price-value"><?php echo esc_html( $full_price ); ?> ₽</span>
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
				<p class="text-center"><?php _e( 'Автомобили пока не добавлены.', 'shumoff' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
