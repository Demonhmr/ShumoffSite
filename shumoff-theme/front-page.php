<?php
/**
 * Front page template (static front page).
 *
 * @package Shumoff_Theme
 */

get_header();
?>

<main class="page-content">

	<!-- ============================================================
	     HERO SECTION
	     ============================================================ -->
	<section class="hero-section" aria-label="Главный баннер">
		<div class="container">
			<div class="hero-section__inner">
				<div class="hero-section__content">
					<h1 class="hero-section__title">Профессиональная шумоизоляция автомобилей в Подольске и Москве</h1>
					<p class="hero-section__subtitle">Полная и частичная шумоизоляция любой марки автомобилей. Работаем с 2010 года. Гарантия качества 12 месяцев.</p>
					<div class="hero-section__actions">
						<a href="#appointment" class="btn btn-primary"><?php _e( 'Записаться на консультацию', 'shumoff' ); ?></a>
						<a href="#packages" class="btn btn-outline"><?php _e( 'Смотреть комплекты', 'shumoff' ); ?></a>
					</div>
				</div>
				<div class="hero-section__image">
					<svg viewBox="0 0 500 400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Шумоизоляция автомобиля" style="width:100%;max-width:500px;border-radius:12px;background:var(--color-bg-alt);display:block;">
						<rect width="500" height="400" fill="var(--color-bg-alt)"/>
						<text x="250" y="190" text-anchor="middle" font-family="var(--font-body)" font-size="18" fill="#999">Hero Image Placeholder</text>
						<text x="250" y="215" text-anchor="middle" font-family="var(--font-body)" font-size="14" fill="#bbb">500 × 400 px</text>
					</svg>
				</div>
			</div>
		</div>
	</section>

	<!-- ============================================================
	     ADVANTAGES SECTION — 6 CARDS
	     ============================================================ -->
	<section class="advantages-section section" aria-label="Преимущества">
		<div class="container">
			<h2 class="section-title text-center"><?php _e( 'Почему выбирают нас', 'shumoff' ); ?></h2>
			<p class="section-subtitle text-center"><?php _e( '6 причин доверить шумоизоляцию нашему сервису', 'shumoff' ); ?></p>

			<div class="advantages-grid">

				<article class="advantage-card">
					<div class="advantage-card__icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
					</div>
					<h3 class="advantage-card__title"><?php _e( 'Официальный дилер', 'shumoff' ); ?></h3>
					<p class="advantage-card__desc"><?php _e( 'Работаем с проверенными материалами от ведущих мировых производителей шумоизоляции.', 'shumoff' ); ?></p>
				</article>

				<article class="advantage-card">
					<div class="advantage-card__icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
					</div>
					<h3 class="advantage-card__title"><?php _e( 'Опыт 10+ лет', 'shumoff' ); ?></h3>
					<p class="advantage-card__desc"><?php _e( 'Более 10 лет на рынке шумоизоляции. Тысячи выполненных заказов по всей Москве и Подольску.', 'shumoff' ); ?></p>
				</article>

				<article class="advantage-card">
					<div class="advantage-card__icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
					</div>
					<h3 class="advantage-card__title"><?php _e( 'Гарантия 12 мес', 'shumoff' ); ?></h3>
					<p class="advantage-card__desc"><?php _e( 'Предоставляем гарантию 12 месяцев на все выполненные работы и использованные материалы.', 'shumoff' ); ?></p>
				</article>

				<article class="advantage-card">
					<div class="advantage-card__icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
					</div>
					<h3 class="advantage-card__title"><?php _e( 'Фотоотчёт', 'shumoff' ); ?></h3>
					<p class="advantage-card__desc"><?php _e( 'Каждый этап работ фотографируется. Вы получаете подробный фотоотчёт о проделанной работе.', 'shumoff' ); ?></p>
				</article>

				<article class="advantage-card">
					<div class="advantage-card__icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
					</div>
					<h3 class="advantage-card__title"><?php _e( 'Фиксированная стоимость', 'shumoff' ); ?></h3>
					<p class="advantage-card__desc"><?php _e( 'Стоимость фиксируется до начала работ и не меняется в процессе. Без скрытых доплат.', 'shumoff' ); ?></p>
				</article>

				<article class="advantage-card">
					<div class="advantage-card__icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
					</div>
					<h3 class="advantage-card__title"><?php _e( 'Соблюдение сборки', 'shumoff' ); ?></h3>
					<p class="advantage-card__desc"><?php _e( 'Строгое соблюдение заводских технологических процессов сборки и разборки автомобиля.', 'shumoff' ); ?></p>
				</article>

			</div>
		</div>
	</section>

	<!-- ============================================================
	     PACKAGES SECTION — редактируются в «Настройках сайта»
	     ============================================================ -->
	<section class="packages-section section section--dark" id="packages" aria-label="Комплекты шумоизоляции">
		<div class="container">
			<h2 class="section-title text-center"><?php _e( 'Комплекты шумоизоляции', 'shumoff' ); ?></h2>
			<p class="section-subtitle text-center"><?php _e( 'Выберите подходящий уровень шумоизоляции для вашего автомобиля', 'shumoff' ); ?></p>

			<div class="packages-grid">
				<?php foreach ( shumoff_get_packages() as $shumoff_package ) : ?>
					<article class="package-card<?php echo $shumoff_package['featured'] ? ' package-card--featured' : ''; ?>">
						<?php if ( $shumoff_package['featured'] ) : ?>
							<div class="package-card__badge"><?php _e( 'Популярный', 'shumoff' ); ?></div>
						<?php endif; ?>
						<div class="package-card__header">
							<h3 class="package-card__title"><?php echo esc_html( $shumoff_package['name'] ); ?></h3>
							<p class="package-card__subtitle"><?php echo esc_html( $shumoff_package['subtitle'] ); ?></p>
						</div>
						<div class="package-card__body">
							<ul class="package-card__list">
								<?php foreach ( $shumoff_package['features'] as $shumoff_feature ) : ?>
									<li><?php echo esc_html( $shumoff_feature ); ?></li>
								<?php endforeach; ?>
							</ul>
							<p class="package-card__price">
								<?php printf( __( 'от %s ₽', 'shumoff' ), esc_html( number_format( (int) $shumoff_package['price_from'], 0, ',', ' ' ) ) ); ?>
							</p>
							<a href="#appointment" class="btn <?php echo $shumoff_package['featured'] ? 'btn-primary' : 'btn-outline'; ?>"><?php _e( 'Рассчитать', 'shumoff' ); ?></a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ============================================================
	     CASES SECTION — последние кейсы из CPT
	     ============================================================ -->
	<section class="cases-section section" aria-label="Наши кейсы">
		<div class="container">
			<h2 class="section-title text-center"><?php _e( 'Наши кейсы', 'shumoff' ); ?></h2>
			<p class="section-subtitle text-center"><?php _e( 'Примеры выполненных работ по шумоизоляции', 'shumoff' ); ?></p>

			<?php
			$shumoff_cases = new WP_Query(
				array(
					'post_type'           => 'cases',
					'posts_per_page'      => 4,
					'ignore_sticky_posts' => true,
				)
			);
			?>

			<?php if ( $shumoff_cases->have_posts() ) : ?>
				<div class="cases-grid">
					<?php
					while ( $shumoff_cases->have_posts() ) :
						$shumoff_cases->the_post();
						$shumoff_case_price = shumoff_field( 'case_price' );
						?>
						<article class="case-card hover-lift">
							<div class="case-card__image">
								<a href="<?php the_permalink(); ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'shumoff-thumbnail' ); ?>
									<?php else : ?>
										<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1.5" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
									<?php endif; ?>
								</a>
							</div>
							<div class="case-card__body">
								<h3 class="case-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p class="case-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
								<?php if ( $shumoff_case_price ) : ?>
									<span class="case-card__meta"><?php printf( __( 'от %s ₽', 'shumoff' ), esc_html( $shumoff_case_price ) ); ?></span>
								<?php endif; ?>
							</div>
						</article>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</div>

				<div class="text-center" style="margin-top:40px;">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'cases' ) ); ?>" class="btn btn-outline"><?php _e( 'Все кейсы', 'shumoff' ); ?></a>
				</div>
			<?php else : ?>
				<p class="text-center"><?php _e( 'Кейсы скоро появятся — мы готовим фотоотчёты выполненных работ.', 'shumoff' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<!-- ============================================================
	     REVIEWS SECTION — отзывы из CPT (скрыта, пока отзывов нет)
	     ============================================================ -->
	<?php
	$shumoff_reviews = new WP_Query(
		array(
			'post_type'           => 'reviews',
			'posts_per_page'      => 3,
			'ignore_sticky_posts' => true,
		)
	);
	?>
	<?php if ( $shumoff_reviews->have_posts() ) : ?>
		<section class="reviews-section section section--alt" aria-label="Отзывы клиентов">
			<div class="container">
				<h2 class="section-title text-center"><?php _e( 'Отзывы клиентов', 'shumoff' ); ?></h2>
				<p class="section-subtitle text-center"><?php _e( 'Что говорят владельцы автомобилей после шумоизоляции', 'shumoff' ); ?></p>

				<div class="reviews-grid">
					<?php
					$shumoff_review_sources = array(
						'yandex' => __( 'Яндекс Карты', 'shumoff' ),
						'2gis'   => __( '2ГИС', 'shumoff' ),
						'video'  => __( 'Видеоотзыв', 'shumoff' ),
						'direct' => __( 'Клиент сервиса', 'shumoff' ),
					);
					while ( $shumoff_reviews->have_posts() ) :
						$shumoff_reviews->the_post();
						$shumoff_rating = min( 5, max( 1, (int) shumoff_field( 'review_rating', false, 5 ) ) );
						$shumoff_source = (string) shumoff_field( 'review_source' );
						?>
						<article class="review-card">
							<div class="review-card__stars" aria-label="<?php echo esc_attr( sprintf( __( 'Оценка %d из 5', 'shumoff' ), $shumoff_rating ) ); ?>">
								<?php echo esc_html( str_repeat( '★', $shumoff_rating ) . str_repeat( '☆', 5 - $shumoff_rating ) ); ?>
							</div>
							<div class="review-card__text"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_content() ), 40 ) ); ?></div>
							<div class="review-card__author">
								<span class="review-card__name"><?php the_title(); ?></span>
								<?php if ( isset( $shumoff_review_sources[ $shumoff_source ] ) ) : ?>
									<span class="review-card__source"><?php echo esc_html( $shumoff_review_sources[ $shumoff_source ] ); ?></span>
								<?php endif; ?>
							</div>
						</article>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- ============================================================
	     FAQ SECTION — источник: shumoff_get_faqs() (общий с JSON-LD)
	     ============================================================ -->
	<section class="faq-section section section--dark" aria-label="Часто задаваемые вопросы">
		<div class="container">
			<h2 class="section-title text-center"><?php _e( 'Часто задаваемые вопросы', 'shumoff' ); ?></h2>

			<div class="faq-list">
				<?php foreach ( shumoff_get_faqs() as $shumoff_faq ) : ?>
					<details class="faq-item">
						<summary class="faq-item__question">
							<span><?php echo esc_html( $shumoff_faq['question'] ); ?></span>
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
						</summary>
						<div class="faq-item__answer">
							<?php echo esc_html( $shumoff_faq['answer'] ); ?>
						</div>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/appointment-form' ); ?>

</main>

<?php
get_footer();

