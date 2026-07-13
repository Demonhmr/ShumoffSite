<?php
/**
 * The template for displaying single car posts.
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
						$terms = get_the_terms( get_the_ID(), 'car_brand' );
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
					$car_class  = shumoff_field( 'car_class' );
					$full_price = shumoff_field( 'car_full_price' );
					?>

					<?php if ( $car_class || $full_price ) : ?>
						<div class="car-details-block">
							<?php if ( $car_class ) : ?>
								<div class="car-detail-item">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
									<div>
										<strong><?php _e( 'Класс автомобиля', 'shumoff' ); ?></strong>
										<span><?php echo esc_html( $car_class ); ?></span>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( $full_price ) : ?>
								<div class="car-detail-item">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
									<div>
										<strong><?php _e( 'Полная шумоизоляция от', 'shumoff' ); ?></strong>
										<span><?php echo esc_html( $full_price ); ?> <?php _e( '₽', 'shumoff' ); ?></span>
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
		     PRICE TABLE — реальный прайс по типу кузова (shumoff-core)
		     ============================================================ -->
		<?php
		$shumoff_body        = $car_class ? $car_class : 'Седан-Хэтчбэк';
		$shumoff_price_table = function_exists( 'shumoff_get_price_table' ) ? shumoff_get_price_table( $shumoff_body ) : null;
		?>

		<?php if ( $shumoff_price_table ) : ?>
			<section class="price-table-section section section--dark" aria-label="Цены по комплектам">
				<div class="container">
					<h2 class="section-title text-center"><?php _e( 'Стоимость шумоизоляции', 'shumoff' ); ?></h2>
					<p class="section-subtitle text-center">
						<?php printf( __( '%1$s — цены для кузова «%2$s»', 'shumoff' ), esc_html( get_the_title() ), esc_html( $shumoff_body ) ); ?>
					</p>

					<div class="price-table-grid">
						<?php
						$shumoff_packages_meta = array(
							'Simple'  => array( 'subtitle' => __( 'Базовый комплект', 'shumoff' ), 'featured' => false ),
							'Medium'  => array( 'subtitle' => __( 'Оптимальный комплект', 'shumoff' ), 'featured' => true ),
							'Premium' => array( 'subtitle' => __( 'Полный комплекс', 'shumoff' ), 'featured' => false ),
						);
						foreach ( $shumoff_packages_meta as $shumoff_package => $shumoff_meta ) :
							?>
							<div class="price-table-card<?php echo $shumoff_meta['featured'] ? ' price-table-card--featured' : ''; ?>">
								<?php if ( $shumoff_meta['featured'] ) : ?>
									<div class="price-table-card__badge"><?php _e( 'Популярный', 'shumoff' ); ?></div>
								<?php endif; ?>
								<h3 class="price-table-card__title"><?php echo esc_html( $shumoff_package ); ?></h3>
								<p class="price-table-card__subtitle"><?php echo esc_html( $shumoff_meta['subtitle'] ); ?></p>
								<table class="price-table">
									<thead>
										<tr>
											<th scope="col"><?php _e( 'Зона обработки', 'shumoff' ); ?></th>
											<th scope="col"><?php _e( 'Цена', 'shumoff' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ( $shumoff_price_table as $shumoff_zone => $shumoff_prices ) : ?>
											<?php if ( 'Полная комплектация' === $shumoff_zone || ! isset( $shumoff_prices[ $shumoff_package ]['total'] ) ) { continue; } ?>
											<tr>
												<td><?php echo esc_html( $shumoff_zone ); ?></td>
												<td><?php echo esc_html( number_format( $shumoff_prices[ $shumoff_package ]['total'], 0, ',', ' ' ) ); ?> ₽</td>
											</tr>
										<?php endforeach; ?>
										<?php if ( isset( $shumoff_price_table['Полная комплектация'][ $shumoff_package ]['total'] ) ) : ?>
											<tr>
												<td><strong><?php _e( 'Полная комплектация', 'shumoff' ); ?></strong></td>
												<td><strong><?php echo esc_html( number_format( $shumoff_price_table['Полная комплектация'][ $shumoff_package ]['total'], 0, ',', ' ' ) ); ?> ₽</strong></td>
											</tr>
										<?php endif; ?>
									</tbody>
								</table>
								<a href="#appointment" class="btn <?php echo $shumoff_meta['featured'] ? 'btn-primary' : 'btn-outline'; ?>"><?php _e( 'Рассчитать', 'shumoff' ); ?></a>
							</div>
						<?php endforeach; ?>
					</div>

					<p class="price-table-note text-center">
						<?php _e( 'Цены включают материалы и работу. Точная стоимость фиксируется после осмотра автомобиля и не меняется в процессе.', 'shumoff' ); ?>
					</p>
				</div>
			</section>
		<?php else : ?>
			<section class="price-table-section section section--dark" aria-label="Цены по комплектам">
				<div class="container text-center">
					<h2 class="section-title"><?php _e( 'Стоимость шумоизоляции', 'shumoff' ); ?></h2>
					<p class="section-subtitle">
						<?php printf( __( 'Рассчитаем стоимость для вашего автомобиля по телефону %s или по заявке ниже.', 'shumoff' ), esc_html( shumoff_contact( 'contact_phone' ) ) ); ?>
					</p>
					<a href="#appointment" class="btn btn-primary"><?php _e( 'Рассчитать стоимость', 'shumoff' ); ?></a>
				</div>
			</section>
		<?php endif; ?>

		<!-- ============================================================
		     RELATED SERVICES
		     ============================================================ -->
		<?php
		$related_services = new WP_Query(
			array(
				'post_type'           => 'services',
				'posts_per_page'      => 4,
				'orderby'             => 'menu_order',
				'order'               => 'ASC',
				'ignore_sticky_posts' => true,
			)
		);

		if ( $related_services->have_posts() ) :
				?>
				<section class="related-services section" aria-label="Связанные услуги">
					<div class="container">
						<h2 class="section-title text-center"><?php _e( 'Наши услуги', 'shumoff' ); ?></h2>
						<p class="section-subtitle text-center"><?php _e( 'Полный спектр шумоизоляционных работ', 'shumoff' ); ?></p>

						<div class="services-grid">
							<?php
							while ( $related_services->have_posts() ) : $related_services->the_post();
								$service_price = shumoff_field( 'service_price_from' );
								$service_duration = shumoff_field( 'service_duration' );
								?>
								<article class="service-card">
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
										<p class="service-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
										<?php if ( $service_price ) : ?>
											<p class="service-card__price"><?php printf( __( 'от %s ₽', 'shumoff' ), esc_html( $service_price ) ); ?></p>
										<?php endif; ?>
										<?php if ( $service_duration ) : ?>
											<p class="service-card__duration">
												<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:4px"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
												<?php echo esc_html( $service_duration ); ?>
											</p>
										<?php endif; ?>
										<a href="<?php the_permalink(); ?>" class="btn btn-outline btn--sm"><?php _e( 'Подробнее', 'shumoff' ); ?></a>
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
		?>

		<?php
		get_template_part( 'template-parts/appointment-form', null, array(
			'text' => sprintf( __( 'Запишитесь на шумоизоляцию для «%s» — наш менеджер перезвонит в течение 15 минут.', 'shumoff' ), get_the_title() ),
		) );
		?>

	</div>
</main>

<?php get_footer(); ?>
