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
		     PRICE TABLE — SIMPLE / MEDIUM / PREMIUM
		     ============================================================ -->
		<section class="price-table-section section section--dark" aria-label="Цены по комплектам">
			<div class="container">
				<h2 class="section-title text-center"><?php _e( 'Стоимость шумоизоляции', 'shumoff' ); ?></h2>
				<p class="section-subtitle text-center"><?php printf( __( 'Цены для автомобиля: %s', 'shumoff' ), esc_html( get_the_title() ) ); ?></p>

				<div class="price-table-grid">

					<!-- SIMPLE -->
					<div class="price-table-card">
						<h3 class="price-table-card__title"><?php _e( 'Simple', 'shumoff' ); ?></h3>
						<p class="price-table-card__subtitle"><?php _e( 'Базовый комплект', 'shumoff' ); ?></p>
						<table class="price-table">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'Зона обработки', 'shumoff' ); ?></th>
									<th scope="col"><?php _e( 'Материал', 'shumoff' ); ?></th>
									<th scope="col"><?php _e( 'Цена', 'shumoff' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php _e( 'Дверные карты (2 шт.)', 'shumoff' ); ?></td>
									<td>StP Agility</td>
									<td><?php echo ! empty( $full_price ) ? number_format( (int) preg_replace( '/\D/', '', $full_price ) * 0.25, 0, ',', ' ' ) : '3 500'; ?> ₽</td>
								</tr>
								<tr>
									<td><?php _e( 'Арки (2 шт.)', 'shumoff' ); ?></td>
									<td>StP Agility</td>
									<td><?php echo ! empty( $full_price ) ? number_format( (int) preg_replace( '/\D/', '', $full_price ) * 0.2, 0, ',', ' ' ) : '2 500'; ?> ₽</td>
								</tr>
								<tr>
									<td><strong><?php _e( 'Итого', 'shumoff' ); ?></strong></td>
									<td></td>
									<td><strong><?php echo ! empty( $full_price ) ? number_format( (int) preg_replace( '/\D/', '', $full_price ) * 0.45, 0, ',', ' ' ) : '6 000'; ?> ₽</strong></td>
								</tr>
							</tbody>
						</table>
						<a href="#appointment" class="btn btn-outline"><?php _e( 'Рассчитать', 'shumoff' ); ?></a>
					</div>

					<!-- MEDIUM -->
					<div class="price-table-card price-table-card--featured">
						<div class="price-table-card__badge"><?php _e( 'Популярный', 'shumoff' ); ?></div>
						<h3 class="price-table-card__title"><?php _e( 'Medium', 'shumoff' ); ?></h3>
						<p class="price-table-card__subtitle"><?php _e( 'Оптимальный комплект', 'shumoff' ); ?></p>
						<table class="price-table">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'Зона обработки', 'shumoff' ); ?></th>
									<th scope="col"><?php _e( 'Материал', 'shumoff' ); ?></th>
									<th scope="col"><?php _e( 'Цена', 'shumoff' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php _e( 'Двери (4 шт.)', 'shumoff' ); ?></td>
									<td>StP Agility + Sphinxx</td>
									<td><?php echo ! empty( $full_price ) ? number_format( (int) preg_replace( '/\D/', '', $full_price ) * 0.28, 0, ',', ' ' ) : '7 000'; ?> ₽</td>
								</tr>
								<tr>
									<td><?php _e( 'Пол (салон)', 'shumoff' ); ?></td>
									<td>StP Magnum + Sphinxx</td>
									<td><?php echo ! empty( $full_price ) ? number_format( (int) preg_replace( '/\D/', '', $full_price ) * 0.25, 0, ',', ' ' ) : '6 000'; ?> ₽</td>
								</tr>
								<tr>
									<td><?php _e( 'Крыша', 'shumoff' ); ?></td>
									<td>StP Sphinxx</td>
									<td><?php echo ! empty( $full_price ) ? number_format( (int) preg_replace( '/\D/', '', $full_price ) * 0.15, 0, ',', ' ' ) : '4 000'; ?> ₽</td>
								</tr>
								<tr>
									<td><?php _e( 'Арки (4 шт.)', 'shumoff' ); ?></td>
									<td>StP Magnum</td>
									<td><?php echo ! empty( $full_price ) ? number_format( (int) preg_replace( '/\D/', '', $full_price ) * 0.17, 0, ',', ' ' ) : '5 000'; ?> ₽</td>
								</tr>
								<tr>
									<td><strong><?php _e( 'Итого', 'shumoff' ); ?></strong></td>
									<td></td>
									<td><strong><?php echo ! empty( $full_price ) ? number_format( (int) preg_replace( '/\D/', '', $full_price ) * 0.85, 0, ',', ' ' ) : '22 000'; ?> ₽</strong></td>
								</tr>
							</tbody>
						</table>
						<a href="#appointment" class="btn btn-primary"><?php _e( 'Рассчитать', 'shumoff' ); ?></a>
					</div>

					<!-- PREMIUM -->
					<div class="price-table-card">
						<h3 class="price-table-card__title"><?php _e( 'Premium', 'shumoff' ); ?></h3>
						<p class="price-table-card__subtitle"><?php _e( 'Полный комплекс', 'shumoff' ); ?></p>
						<table class="price-table">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'Зона обработки', 'shumoff' ); ?></th>
									<th scope="col"><?php _e( 'Материал', 'shumoff' ); ?></th>
									<th scope="col"><?php _e( 'Цена', 'shumoff' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php _e( 'Двери (4 шт.)', 'shumoff' ); ?></td>
									<td>StP Comfort + Sphinxx Gold</td>
									<td><?php echo ! empty( $full_price ) ? number_format( (int) preg_replace( '/\D/', '', $full_price ) * 0.3, 0, ',', ' ' ) : '10 000'; ?> ₽</td>
								</tr>
								<tr>
									<td><?php _e( 'Пол (салон + багажник)', 'shumoff' ); ?></td>
									<td>StP SuperMagma + Sphinxx Gold</td>
									<td><?php echo ! empty( $full_price ) ? number_format( (int) preg_replace( '/\D/', '', $full_price ) * 0.3, 0, ',', ' ' ) : '12 000'; ?> ₽</td>
								</tr>
								<tr>
									<td><?php _e( 'Крыша', 'shumoff' ); ?></td>
									<td>StP Sphinxx Gold</td>
									<td><?php echo ! empty( $full_price ) ? number_format( (int) preg_replace( '/\D/', '', $full_price ) * 0.15, 0, ',', ' ' ) : '6 000'; ?> ₽</td>
								</tr>
								<tr>
									<td><?php _e( 'Арки (4 шт.)', 'shumoff' ); ?></td>
									<td>StP SuperMagma + Flutron</td>
									<td><?php echo ! empty( $full_price ) ? number_format( (int) preg_replace( '/\D/', '', $full_price ) * 0.12, 0, ',', ' ' ) : '5 000'; ?> ₽</td>
								</tr>
								<tr>
									<td><?php _e( 'Капот / багажник', 'shumoff' ); ?></td>
									<td>StP Comfort + Sphinxx</td>
									<td><?php echo ! empty( $full_price ) ? number_format( (int) preg_replace( '/\D/', '', $full_price ) * 0.13, 0, ',', ' ' ) : '5 000'; ?> ₽</td>
								</tr>
								<tr>
									<td><strong><?php _e( 'Итого', 'shumoff' ); ?></strong></td>
									<td></td>
									<td><strong><?php echo ! empty( $full_price ) ? esc_html( $full_price ) : '50 000'; ?> ₽</strong></td>
								</tr>
							</tbody>
						</table>
						<a href="#appointment" class="btn btn-outline"><?php _e( 'Рассчитать', 'shumoff' ); ?></a>
					</div>

				</div>
			</div>
		</section>

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
