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
	     PACKAGES SECTION — SIMPLE / MEDIUM / PREMIUM
	     ============================================================ -->
	<section class="packages-section section section--dark" id="packages" aria-label="Комплекты шумоизоляции">
		<div class="container">
			<h2 class="section-title text-center"><?php _e( 'Комплекты шумоизоляции', 'shumoff' ); ?></h2>
			<p class="section-subtitle text-center"><?php _e( 'Выберите подходящий уровень шумоизоляции для вашего автомобиля', 'shumoff' ); ?></p>

			<div class="packages-grid">

				<!-- SIMPLE -->
				<article class="package-card">
					<div class="package-card__header">
						<h3 class="package-card__title"><?php _e( 'Simple', 'shumoff' ); ?></h3>
						<p class="package-card__subtitle"><?php _e( 'Базовый комплект', 'shumoff' ); ?></p>
					</div>
					<div class="package-card__body">
						<ul class="package-card__list">
							<li><?php _e( 'Шумоизоляция дверных карт (2 шт.)', 'shumoff' ); ?></li>
							<li><?php _e( 'Шумоизоляция арок (2 шт.)', 'shumoff' ); ?></li>
							<li><?php _e( 'Тонкий виброизолятор', 'shumoff' ); ?></li>
							<li><?php _e( 'Время: 1-2 дня', 'shumoff' ); ?></li>
						</ul>
						<p class="package-card__price">
							<?php printf( __( 'от %s ₽', 'shumoff' ), '15 000' ); ?>
						</p>
						<a href="#appointment" class="btn btn-outline"><?php _e( 'Рассчитать', 'shumoff' ); ?></a>
					</div>
				</article>

				<!-- MEDIUM -->
				<article class="package-card package-card--featured">
					<div class="package-card__badge"><?php _e( 'Популярный', 'shumoff' ); ?></div>
					<div class="package-card__header">
						<h3 class="package-card__title"><?php _e( 'Medium', 'shumoff' ); ?></h3>
						<p class="package-card__subtitle"><?php _e( 'Оптимальный комплект', 'shumoff' ); ?></p>
					</div>
					<div class="package-card__body">
						<ul class="package-card__list">
							<li><?php _e( 'Шумоизоляция дверей (4 шт.)', 'shumoff' ); ?></li>
							<li><?php _e( 'Шумоизоляция пола (в салон)', 'shumoff' ); ?></li>
							<li><?php _e( 'Шумоизоляция крыши', 'shumoff' ); ?></li>
							<li><?php _e( 'Шумоизоляция арок (4 шт.)', 'shumoff' ); ?></li>
							<li><?php _e( 'Вибро + шумоизолятор', 'shumoff' ); ?></li>
							<li><?php _e( 'Время: 2-3 дня', 'shumoff' ); ?></li>
						</ul>
						<p class="package-card__price">
							<?php printf( __( 'от %s ₽', 'shumoff' ), '35 000' ); ?>
						</p>
						<a href="#appointment" class="btn btn-primary"><?php _e( 'Рассчитать', 'shumoff' ); ?></a>
					</div>
				</article>

				<!-- PREMIUM -->
				<article class="package-card">
					<div class="package-card__header">
						<h3 class="package-card__title"><?php _e( 'Premium', 'shumoff' ); ?></h3>
						<p class="package-card__subtitle"><?php _e( 'Полный комплекс', 'shumoff' ); ?></p>
					</div>
					<div class="package-card__body">
						<ul class="package-card__list">
							<li><?php _e( 'Шумоизоляция всех дверей (4 шт.)', 'shumoff' ); ?></li>
							<li><?php _e( 'Шумоизоляция пола (в салон + багажник)', 'shumoff' ); ?></li>
							<li><?php _e( 'Шумоизоляция крыши', 'shumoff' ); ?></li>
							<li><?php _e( 'Шумоизоляция арок (4 шт.)', 'shumoff' ); ?></li>
							<li><?php _e( 'Шумоизоляция капота / багажника', 'shumoff' ); ?></li>
							<li><?php _e( 'Премиум-материалы', 'shumoff' ); ?></li>
							<li><?php _e( 'Время: 4-5 дней', 'shumoff' ); ?></li>
						</ul>
						<p class="package-card__price">
							<?php printf( __( 'от %s ₽', 'shumoff' ), '60 000' ); ?>
						</p>
						<a href="#appointment" class="btn btn-outline"><?php _e( 'Рассчитать', 'shumoff' ); ?></a>
					</div>
				</article>

			</div>
		</div>
	</section>

	<!-- ============================================================
	     CASES SECTION — 4 PLACEHOLDER CARDS
	     ============================================================ -->
	<section class="cases-section section" aria-label="Наши кейсы">
		<div class="container">
			<h2 class="section-title text-center"><?php _e( 'Наши кейсы', 'shumoff' ); ?></h2>
			<p class="section-subtitle text-center"><?php _e( 'Примеры выполненных работ по шумоизоляции', 'shumoff' ); ?></p>

			<div class="cases-grid">

				<article class="case-card">
					<div class="case-card__image" style="background:var(--color-bg-alt);height:200px;display:flex;align-items:center;justify-content:center;">
						<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
					</div>
					<div class="case-card__body">
						<h3 class="case-card__title"><a href="#"><?php _e( 'Toyota Camry — полная шумоизоляция', 'shumoff' ); ?></a></h3>
						<p class="case-card__excerpt"><?php _e( 'Полная шумоизоляция кузова: двери, пол, крыша, арки, капот. Использование материалов StP Magnum.', 'shumoff' ); ?></p>
						<span class="case-card__meta"><?php _e( 'от 65 000 ₽', 'shumoff' ); ?></span>
					</div>
				</article>

				<article class="case-card">
					<div class="case-card__image" style="background:var(--color-bg-alt);height:200px;display:flex;align-items:center;justify-content:center;">
						<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
					</div>
					<div class="case-card__body">
						<h3 class="case-card__title"><a href="#"><?php _e( 'Kia Rio — шумоизоляция дверей', 'shumoff' ); ?></a></h3>
						<p class="case-card__excerpt"><?php _e( 'Шумоизоляция всех дверей с улучшением звучания аудиосистемы. Материалы StP Accent и Sphinxx.', 'shumoff' ); ?></p>
						<span class="case-card__meta"><?php _e( 'от 18 000 ₽', 'shumoff' ); ?></span>
					</div>
				</article>

				<article class="case-card">
					<div class="case-card__image" style="background:var(--color-bg-alt);height:200px;display:flex;align-items:center;justify-content:center;">
						<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
					</div>
					<div class="case-card__body">
						<h3 class="case-card__title"><a href="#"><?php _e( 'BMW X5 — Medium комплект', 'shumoff' ); ?></a></h3>
						<p class="case-card__excerpt"><?php _e( 'Средний комплекс шумоизоляции: пол, двери, арки, крыша. Результат: снижение шума на 8 дБ.', 'shumoff' ); ?></p>
						<span class="case-card__meta"><?php _e( 'от 45 000 ₽', 'shumoff' ); ?></span>
					</div>
				</article>

				<article class="case-card">
					<div class="case-card__image" style="background:var(--color-bg-alt);height:200px;display:flex;align-items:center;justify-content:center;">
						<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
					</div>
					<div class="case-card__body">
						<h3 class="case-card__title"><a href="#"><?php _e( 'Volkswagen Tiguan — шумоизоляция пола', 'shumoff' ); ?></a></h3>
						<p class="case-card__excerpt"><?php _e( 'Шумоизоляция пола и багажника Premium-материалами. Значительное снижение шума дороги и выхлопа.', 'shumoff' ); ?></p>
						<span class="case-card__meta"><?php _e( 'от 30 000 ₽', 'shumoff' ); ?></span>
					</div>
				</article>

			</div>

			<div class="text-center" style="margin-top:40px;">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'cases' ) ); ?>" class="btn btn-outline"><?php _e( 'Все кейсы', 'shumoff' ); ?></a>
			</div>
		</div>
	</section>

	<!-- ============================================================
	     FAQ SECTION — 5 Q&A
	     ============================================================ -->
	<section class="faq-section section section--dark" aria-label="Часто задаваемые вопросы">
		<div class="container">
			<h2 class="section-title text-center"><?php _e( 'Часто задаваемые вопросы', 'shumoff' ); ?></h2>

			<div class="faq-list">

				<details class="faq-item">
					<summary class="faq-item__question">
						<span><?php _e( 'Сколько времени занимает шумоизоляция?', 'shumoff' ); ?></span>
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
					</summary>
					<div class="faq-item__answer">
						<?php _e( 'Время зависит от выбранного комплекта. Simple — 1-2 дня, Medium — 2-3 дня, Premium — 4-5 дней. Мы всегда стараемся выполнить работу в кратчайшие сроки, не жертвуя качеством.', 'shumoff' ); ?>
					</div>
				</details>

				<details class="faq-item">
					<summary class="faq-item__question">
						<span><?php _e( 'Какие материалы вы используете?', 'shumoff' ); ?></span>
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
					</summary>
					<div class="faq-item__answer">
						<?php _e( 'Мы работаем с проверенными брендами: StP (СтандартПласт), SoftLine, Шумайз, Akston. Материалы сертифицированы и имеют гарантию производителя.', 'shumoff' ); ?>
					</div>
				</details>

				<details class="faq-item">
					<summary class="faq-item__question">
						<span><?php _e( 'Даёте ли вы гарантию на работу?', 'shumoff' ); ?></span>
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
					</summary>
					<div class="faq-item__answer">
						<?php _e( 'Да, мы предоставляем гарантию 12 месяцев на все выполненные работы. Если в течение гарантийного срока обнаружится дефект — устраним бесплатно.', 'shumoff' ); ?>
					</div>
				</details>

				<details class="faq-item">
					<summary class="faq-item__question">
						<span><?php _e( 'Можно ли присутствовать при работе?', 'shumoff' ); ?></span>
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
					</summary>
					<div class="faq-item__answer">
						<?php _e( 'Конечно! Вы можете присутствовать в нашей зоне ожидания с Wi-Fi и кофе. Также мы делаем подробный фотоотчёт на каждом этапе работ.', 'shumoff' ); ?>
					</div>
				</details>

				<details class="faq-item">
					<summary class="faq-item__question">
						<span><?php _e( 'Как записаться на шумоизоляцию?', 'shumoff' ); ?></span>
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
					</summary>
					<div class="faq-item__answer">
						<?php _e( 'Записаться можно по телефону +7 (495) 117-63-37, через WhatsApp, Telegram или заполнив форму на сайте. Мы перезвоним в течение 15 минут и подберём удобное время.', 'shumoff' ); ?>
					</div>
				</details>

			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/appointment-form' ); ?>

</main>

<?php
get_footer();

