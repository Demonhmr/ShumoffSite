<?php
/**
 * Archive template for cases CPT.
 *
 * @package Shumoff_Theme
 */

get_header();
?>

<section class="archive-section section section--dark">
	<div class="container">
		<h1 class="section-title text-center"><?php _e( 'Кейсы', 'shumoff' ); ?></h1>
		<p class="section-subtitle text-center">
			<?php
			if ( is_tax( 'case_type' ) ) :
				$term = get_queried_object();
				if ( $term ) :
					printf( __( 'Кейсы категории: %s', 'shumoff' ), esc_html( $term->name ) );
				else :
					the_archive_title();
				endif;
			else :
				_e( 'Портфолио выполненных работ по шумоизоляции', 'shumoff' );
			endif;
			?>
		</p>
	</div>
</section>

<section class="archive-cases section">
	<div class="container">
		<div class="cases-grid">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					$gallery = get_field( 'case_gallery' );
					$price   = get_field( 'case_price' );
					$time    = get_field( 'case_time' );
					?>

					<article class="case-card hover-lift">
						<div class="case-card__image">
							<a href="<?php the_permalink(); ?>">
								<?php
								if ( $gallery && ! empty( $gallery ) && isset( $gallery[0]['url'] ) ) :
									?>
									<img src="<?php echo esc_url( $gallery[0]['url'] ); ?>"
										 alt="<?php the_title_attribute(); ?>"
										 loading="lazy">
									<?php
								elseif ( has_post_thumbnail() ) :
									the_post_thumbnail( 'shumoff-thumb-medium' );
								else :
									?>
									<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1.5" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
									<?php
								endif;
								?>
							</a>
						</div>

						<div class="case-card__content">
							<h3 class="case-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>

							<?php if ( $price ) : ?>
								<p class="case-card__price"><?php printf( __( 'от %s ₽', 'shumoff' ), esc_html( $price ) ); ?></p>
							<?php endif; ?>

							<?php if ( $time ) : ?>
								<p class="case-card__meta">
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:4px"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
									<?php echo esc_html( $time ); ?>
								</p>
							<?php endif; ?>

							<a href="<?php the_permalink(); ?>" class="case-card__link">
								<?php _e( 'Смотреть кейс →', 'shumoff' ); ?>
							</a>
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
				<p class="text-center"><?php _e( 'Кейсы пока не добавлены.', 'shumoff' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
