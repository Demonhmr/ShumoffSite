<?php
/**
 * The template for displaying single service posts.
 *
 * @package Shumoff_Theme
 */

get_header();
?>

<main class="page-content">
	<div class="single-template-content">

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<header class="entry-header">
						<?php
						$terms = get_the_terms( get_the_ID(), 'case_type' );
						if ( $terms && ! is_wp_error( $terms ) ) :
							foreach ( $terms as $term ) :
								?>
								<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="entry-term">
									<?php echo esc_html( $term->name ); ?>
								</a>
								<?php
							endforeach;
						endif;
						?>
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header>

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="entry-featured">
							<?php the_post_thumbnail( 'large' ); ?>
						</div>
					<?php endif; ?>

					<div class="entry-content">
						<?php the_content(); ?>
					</div>

					<?php
					// ACF Custom Fields
					$price_from  = shumoff_field( 'service_price_from' );
					$duration    = shumoff_field( 'service_duration' );
					?>

					<?php if ( $price_from || $duration ) : ?>
						<div class="service-details-block">
							<?php if ( $price_from ) : ?>
								<div class="service-detail-item service-detail-item--price">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
									<div>
										<strong><?php _e( 'Стоимость', 'shumoff' ); ?></strong>
										<span><?php echo esc_html( $price_from ); ?></span>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( $duration ) : ?>
								<div class="service-detail-item service-detail-item--duration">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
									<div>
										<strong><?php _e( 'Время выполнения', 'shumoff' ); ?></strong>
										<span><?php echo esc_html( $duration ); ?></span>
									</div>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

				</article>

				<?php
			endwhile;
		endif;
		?>

		<!-- ============================================================
		     RELATED CASES SECTION
		     ============================================================ -->
		<?php
		$service_type_terms = get_the_terms( get_the_ID(), 'case_type' );
		$term_ids           = array();
		if ( $service_type_terms && ! is_wp_error( $service_type_terms ) ) {
			foreach ( $service_type_terms as $term ) {
				$term_ids[] = $term->term_id;
			}
		}

		if ( ! empty( $term_ids ) ) :
			$related_args = array(
				'post_type'      => 'cases',
				'posts_per_page' => 4,
				'tax_query'      => array(
					array(
						'taxonomy' => 'case_type',
						'field'    => 'term_id',
						'terms'    => $term_ids,
					),
				),
				'ignore_sticky_posts' => true,
			);
			$related_query = new WP_Query( $related_args );

			if ( $related_query->have_posts() ) :
				?>
				<section class="related-cases section" aria-label="Связанные кейсы">
					<div class="container">
						<h2 class="section-title text-center"><?php _e( 'Связанные кейсы', 'shumoff' ); ?></h2>
						<p class="section-subtitle text-center"><?php _e( 'Примеры выполненных работ по данной услуге', 'shumoff' ); ?></p>

						<div class="cases-grid">
							<?php
							while ( $related_query->have_posts() ) : $related_query->the_post();
								$case_price  = shumoff_field( 'case_price' );
								$case_time   = shumoff_field( 'case_time' );
								$gallery     = shumoff_field( 'case_gallery' );
								?>
								<article class="case-card">
									<div class="case-card__image">
										<a href="<?php the_permalink(); ?>">
											<?php
											if ( $gallery && ! empty( $gallery[0] ) ) :
												shumoff_acf_image( $gallery[0], 'shumoff-thumbnail', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) );
											elseif ( has_post_thumbnail() ) :
												the_post_thumbnail( 'shumoff-thumbnail' );
											else :
												?>
												<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
												<?php
											endif;
											?>
										</a>
									</div>
									<div class="case-card__body">
										<h3 class="case-card__title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
										<?php if ( $case_price ) : ?>
											<p class="case-card__price"><?php printf( __( 'от %s ₽', 'shumoff' ), esc_html( $case_price ) ); ?></p>
										<?php endif; ?>
										<?php if ( $case_time ) : ?>
											<p class="case-card__meta">
												<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:4px"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
												<?php echo esc_html( $case_time ); ?>
											</p>
										<?php endif; ?>
										<a href="<?php the_permalink(); ?>" class="case-card__link">
											<?php _e( 'Смотреть кейс →', 'shumoff' ); ?>
										</a>
									</div>
								</article>
								<?php
							endwhile;
							wp_reset_postdata();
							?>
						</div>
					</div>
				</section>
				<?php
			endif;
		endif;
		?>

		<?php
		get_template_part( 'template-parts/appointment-form', null, array(
			'title' => __( 'Оставить заявку на услугу', 'shumoff' ),
			'text'  => sprintf( __( 'Запишитесь на «%s» — наш менеджер перезвонит для уточнения деталей и расчёта стоимости.', 'shumoff' ), get_the_title() ),
		) );
		?>

	</div>
</main>

<?php get_footer(); ?>
