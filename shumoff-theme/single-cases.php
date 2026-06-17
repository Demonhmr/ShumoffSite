<?php
/**
 * The template for displaying single case posts.
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
					$gallery       = function_exists( 'get_field' ) ? get_field( 'case_gallery' ) : null;
					$materials     = function_exists( 'get_field' ) ? get_field( 'case_materials' ) : null;
					$price         = function_exists( 'get_field' ) ? get_field( 'case_price' ) : null;
					$case_time     = function_exists( 'get_field' ) ? get_field( 'case_time' ) : null;
					$noise_before  = function_exists( 'get_field' ) ? get_field( 'case_noise_before' ) : null;
					$noise_after   = function_exists( 'get_field' ) ? get_field( 'case_noise_after' ) : null;
					?>

					<!-- ============================================================
					     GALLERY SECTION
					     ============================================================ -->
					<?php if ( $gallery && ! empty( $gallery ) ) : ?>
						<section class="case-gallery-section" aria-label="Галерея фото">
							<h2 class="section-title"><?php _e( 'Фотографии процесса', 'shumoff' ); ?></h2>
							<div class="case-gallery__grid">
								<?php foreach ( $gallery as $image ) : ?>
									<figure class="case-gallery__item">
										<img src="<?php echo esc_url( $image['url'] ); ?>"
										     alt="<?php echo esc_attr( isset( $image['alt'] ) ? $image['alt'] : get_the_title() ); ?>"
										     width="<?php echo esc_attr( isset( $image['width'] ) ? $image['width'] : 800 ); ?>"
										     height="<?php echo esc_attr( isset( $image['height'] ) ? $image['height'] : 600 ); ?>"
										     loading="lazy">
									</figure>
								<?php endforeach; ?>
							</div>
						</section>
					<?php endif; ?>

					<!-- ============================================================
					     CASE METADATA
					     ============================================================ -->
					<div class="case-meta-block">
						<?php if ( $price ) : ?>
							<div class="case-meta-item">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
								<div>
									<strong><?php _e( 'Стоимость', 'shumoff' ); ?></strong>
									<span><?php echo esc_html( $price ); ?> <?php _e( '₽', 'shumoff' ); ?></span>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( $case_time ) : ?>
							<div class="case-meta-item">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
								<div>
									<strong><?php _e( 'Время выполнения', 'shumoff' ); ?></strong>
									<span><?php echo esc_html( $case_time ); ?></span>
								</div>
							</div>
						<?php endif; ?>
					</div>

					<!-- ============================================================
					     MATERIALS SECTION
					     ============================================================ -->
					<?php if ( $materials ) : ?>
						<section class="case-materials-section" aria-label="Использованные материалы">
							<h2 class="section-title"><?php _e( 'Использованные материалы', 'shumoff' ); ?></h2>
							<div class="case-materials__list">
								<?php
								$materials_lines = array_filter( array_map( 'trim', explode( "\n", $materials ) ) );
								foreach ( $materials_lines as $material ) :
									if ( ! empty( $material ) ) :
										?>
										<div class="case-materials__item">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
											<span><?php echo esc_html( $material ); ?></span>
										</div>
										<?php
									endif;
								endforeach;
								?>
							</div>
						</section>
					<?php endif; ?>

					<!-- ============================================================
					     BEFORE/AFTER NOISE MEASUREMENT BLOCK
					     ============================================================ -->
					<?php if ( $noise_before || $noise_after ) : ?>
						<section class="case-noise-section" aria-label="Измерения шума">
							<h2 class="section-title"><?php _e( 'Результаты измерений шума', 'shumoff' ); ?></h2>
							<div class="noise-measurement-block">

								<div class="noise-measurement-block__before">
									<div class="noise-measurement-block__label">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e74c3c" stroke-width="2"><path d="M11 5L6 9H2v6h4l5 4V5z"/><line x1="23" y1="9" x2="17" y2="15"/><line x1="17" y1="9" x2="23" y2="15"/></svg>
										<span><?php _e( 'Шум ДО', 'shumoff' ); ?></span>
									</div>
									<div class="noise-measurement-block__value">
										<?php echo esc_html( $noise_before ); ?>
										<abbr title="decibels">дБ</abbr>
									</div>
								</div>

								<div class="noise-measurement-block__arrow">
									<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="2"><polyline points="13 17 18 12 13 7"/><polyline points="6 17 11 12 6 7"/></svg>
								</div>

								<div class="noise-measurement-block__after">
									<div class="noise-measurement-block__label">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#27ae60" stroke-width="2"><path d="M11 5L6 9H2v6h4l5 4V5z"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>
										<span><?php _e( 'Шум ПОСЛЕ', 'shumoff' ); ?></span>
									</div>
									<div class="noise-measurement-block__value">
										<?php echo esc_html( $noise_after ); ?>
										<abbr title="decibels">дБ</abbr>
									</div>
								</div>

							</div>

							<?php if ( $noise_before && $noise_after ) : ?>
								<div class="noise-reduction-badge">
									<?php
									$reduction = intval( $noise_before ) - intval( $noise_after );
									if ( $reduction > 0 ) :
										echo sprintf( __( 'Снижение шума на %s дБ', 'shumoff' ), esc_html( $reduction ) );
									else :
										echo sprintf( __( 'Снижение шума на %s %%', 'shumoff' ), esc_html( round( ( ( intval( $noise_before ) - intval( $noise_after ) ) / intval( $noise_before ) ) * 100 ) ) );
									endif;
									?>
								</div>
							<?php endif; ?>
						</section>
					<?php endif; ?>

				</article>

				<?php
			endwhile;
		endif;
		?>

		<!-- ============================================================
		     APPOINTMENT FORM
		     ============================================================ -->
		<section class="appointment-section section" id="appointment" aria-label="Форма заявки">
			<div class="container">
				<div class="appointment-section__inner">
					<div class="appointment-section__content">
						<h2 class="appointment-section__title"><?php _e( 'Хотите такой же результат?', 'shumoff' ); ?></h2>
						<p class="appointment-section__text"><?php _e( 'Запишитесь на шумоизоляцию — мы добьёмся такого же эффекта для вашего автомобиля!', 'shumoff' ); ?></p>
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
