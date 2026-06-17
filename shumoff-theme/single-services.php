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
					$price_from  = function_exists( 'get_field' ) ? get_field( 'service_price_from' ) : null;
					$duration    = function_exists( 'get_field' ) ? get_field( 'service_duration' ) : null;
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
								$case_price  = function_exists( 'get_field' ) ? get_field( 'case_price' ) : null;
								$case_time   = function_exists( 'get_field' ) ? get_field( 'case_time' ) : null;
								$gallery     = function_exists( 'get_field' ) ? get_field( 'case_gallery' ) : null;
								?>
								<article class="case-card">
									<div class="case-card__image">
										<a href="<?php the_permalink(); ?>">
											<?php
											if ( $gallery && ! empty( $gallery ) && isset( $gallery[0]['url'] ) ) :
												?>
												<img src="<?php echo esc_url( $gallery[0]['url'] ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
												<?php
											elseif ( has_post_thumbnail() ) :
												the_post_thumbnail( 'shumoff-thumb-medium' );
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

		<!-- ============================================================
		     APPOINTMENT FORM
		     ============================================================ -->
		<section class="appointment-section section" id="appointment" aria-label="Форма заявки">
			<div class="container">
				<div class="appointment-section__inner">
					<div class="appointment-section__content">
						<h2 class="appointment-section__title"><?php _e( 'Оставить заявку на услугу', 'shumoff' ); ?></h2>
						<p class="appointment-section__text"><?php printf( __( 'Запишитесь на "%s" — наш менеджер перезвонит для уточнения деталей и расчёта стоимости.', 'shumoff' ), esc_html( get_the_title() ) ); ?></p>
						<ul class="appointment-section__benefits">
							<li><?php _e( 'Бесплатная консультация', 'shumoff' ); ?></li>
							<li><?php _e( 'Индивидуальный расчёт', 'shumoff' ); ?></li>
							<li><?php _e( 'Скидка 5% при записи онлайн', 'shumoff' ); ?></li>
						</ul>
					</div>

					<div class="appointment-section__form">
						<form class="appointment-form" method="post" action="<?php echo esc_url( home_url( '/' ) ); ?>" novalidate>
							<div class="form-group">
								<label for="appt-name"><?php _e( 'Ваше имя', 'shumoff' ); ?> <span class="required">*</span></label>
								<input type="text" id="appt-name" name="appt_name" placeholder="<?php _e( 'Иван Иванов', 'shumoff' ); ?>" required>
							</div>

							<div class="form-group">
								<label for="appt-phone"><?php _e( 'Телефон', 'shumoff' ); ?> <span class="required">*</span></label>
								<input type="tel" id="appt-phone" name="appt_phone" placeholder="+7 (___) ___-__-__" required>
							</div>

							<div class="form-group">
								<label for="appt-car"><?php _e( 'Марка автомобиля', 'shumoff' ); ?></label>
								<select id="appt-car" name="appt_car">
									<option value=""><?php _e( 'Выберите марку', 'shumoff' ); ?></option>
									<option value="lada">LADA</option>
									<option value="kia">KIA</option>
									<option value="hyundai">Hyundai</option>
									<option value="toyota">Toyota</option>
									<option value="bmw">BMW</option>
									<option value="mercedes">Mercedes-Benz</option>
									<option value="volkswagen">Volkswagen</option>
									<option value="skoda">Škoda</option>
									<option value="nissan">Nissan</option>
									<option value="renault">Renault</option>
									<option value="other"><?php _e( 'Другая', 'shumoff' ); ?></option>
								</select>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary btn--lg" style="width:100%;"><?php _e( 'Рассчитать', 'shumoff' ); ?></button>
							</div>

							<p class="appointment-form__privacy">
								<?php _e( 'Нажимая кнопку, вы соглашаетесь с', 'shumoff' ); ?> <a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><?php _e( 'политикой конфиденциальности', 'shumoff' ); ?></a>.
							</p>
						</form>
					</div>
				</div>
			</div>
		</section>

	</div>
</main>

<?php get_footer(); ?>
