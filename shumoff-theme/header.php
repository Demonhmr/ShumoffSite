<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- ===== SEO Meta Tags ===== -->
	<?php
	$shumoff_seo = shumoff_get_seo_meta();
	?>
	<title><?php echo esc_html( $shumoff_seo['title'] ); ?></title>
	<meta name="description" content="<?php echo esc_attr( $shumoff_seo['description'] ); ?>">
	<meta name="keywords" content="<?php echo esc_attr( $shumoff_seo['keywords'] ); ?>">
	<meta name="robots" content="index, follow">
	<meta name="author" content="Shumoff Podolsk">

	<!-- ===== Open Graph ===== -->
	<meta property="og:type" content="<?php echo is_front_page() ? 'website' : 'article'; ?>">
	<meta property="og:title" content="<?php echo esc_attr( $shumoff_seo['title'] ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $shumoff_seo['description'] ); ?>">
	<meta property="og:url" content="<?php echo esc_url( $shumoff_seo['url'] ); ?>">
	<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
	<meta property="og:locale" content="ru_RU">
	<?php if ( ! empty( $shumoff_seo['image'] ) ) : ?>
		<meta property="og:image" content="<?php echo esc_url( $shumoff_seo['image'] ); ?>">
	<?php endif; ?>

	<!-- ===== Twitter Card ===== -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo esc_attr( $shumoff_seo['title'] ); ?>">
	<meta name="twitter:description" content="<?php echo esc_attr( $shumoff_seo['description'] ); ?>">
	<?php if ( ! empty( $shumoff_seo['image'] ) ) : ?>
		<meta name="twitter:image" content="<?php echo esc_url( $shumoff_seo['image'] ); ?>">
	<?php endif; ?>

	<!-- ===== Canonical ===== -->
	<link rel="canonical" href="<?php echo esc_url( $shumoff_seo['url'] ); ?>">

	<!-- ===== Favicon ===== -->
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php if ( has_site_icon() ) : ?>
		<?php wp_site_icon(); ?>
	<?php else : ?>
		<link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%23FF6B00'/><text x='50' y='68' font-family='Arial' font-size='52' font-weight='bold' fill='white' text-anchor='middle'>S</text></svg>">
	<?php endif; ?>

	<!-- ===== Schema.org LocalBusiness (JSON-LD) ===== -->
	<?php if ( is_front_page() ) : ?>
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "AutoRepair",
		"name": "Shumoff Podolsk",
		"description": "Профессиональная шумоизоляция автомобилей в Подольске и Москве",
		"url": "<?php echo esc_url( home_url( '/' ) ); ?>",
		"telephone": "+74951176337",
		"email": "info@shumoffpodolsk.com",
		"address": {
			"@type": "PostalAddress",
			"addressLocality": "Подольск",
			"addressRegion": "Московская область",
			"addressCountry": "RU"
		},
		"geo": {
			"@type": "GeoCoordinates",
			"latitude": 55.4242,
			"longitude": 37.5459
		},
		"openingHoursSpecification": [{
			"@type": "OpeningHoursSpecification",
			"dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
			"opens": "09:00",
			"closes": "20:00"
		}],
		"priceRange": "15000-60000 RUB",
		"areaServed": ["Подольск", "Москва", "Московская область"],
		"sameAs": [
			"https://wa.me/74951176337",
			"https://t.me/shumoffpodolsk"
		]
	}
	</script>
	<?php endif; ?>

	<!-- ===== FAQ Schema (JSON-LD) on front page ===== -->
	<?php if ( is_front_page() ) : ?>
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "FAQPage",
		"mainEntity": [
			{
				"@type": "Question",
				"name": "Сколько времени занимает шумоизоляция?",
				"acceptedAnswer": {
					"@type": "Answer",
					"text": "Время зависит от выбранного комплекта. Simple — 1-2 дня, Medium — 2-3 дня, Premium — 4-5 дней. Мы всегда стараемся выполнить работу в кратчайшие сроки, не жертвуя качеством."
				}
			},
			{
				"@type": "Question",
				"name": "Какие материалы вы используете?",
				"acceptedAnswer": {
					"@type": "Answer",
					"text": "Мы работаем с проверенными брендами: StP (СтандартПласт), SoftLine, Шумайз, Akston. Материалы сертифицированы и имеют гарантию производителя."
				}
			},
			{
				"@type": "Question",
				"name": "Даёте ли вы гарантию на работу?",
				"acceptedAnswer": {
					"@type": "Answer",
					"text": "Да, мы предоставляем гарантию 12 месяцев на все выполненные работы. Если в течение гарантийного срока обнаружится дефект — устраним бесплатно."
				}
			},
			{
				"@type": "Question",
				"name": "Можно ли присутствовать при работе?",
				"acceptedAnswer": {
					"@type": "Answer",
					"text": "Конечно! Вы можете присутствовать в нашей зоне ожидания с Wi-Fi и кофе. Также мы делаем подробный фотоотчёт на каждом этапе работ."
				}
			},
			{
				"@type": "Question",
				"name": "Как записаться на шумоизоляцию?",
				"acceptedAnswer": {
					"@type": "Answer",
					"text": "Записаться можно по телефону +7 (495) 117-63-37, через WhatsApp, Telegram или заполнив форму на сайте. Мы перезвоним в течение 15 минут и подберём удобное время."
				}
			}
		]
	}
	</script>
	<?php endif; ?>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ===== Mobile Menu Overlay ===== -->
<div class="mobile-menu-overlay" id="mobile-menu-overlay" aria-hidden="true"></div>

<header class="site-header" id="site-header">
	<div class="container">
		<div class="site-header__inner">

			<!-- Logo -->
			<div class="site-header__logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<span class="site-header__logo-text"><?php bloginfo( 'name' ); ?></span>
					<?php endif; ?>
				</a>
			</div>

			<!-- Navigation -->
			<nav class="site-header__nav" id="main-navigation">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'header-menu',
						'menu_id'        => 'header-menu-items',
						'menu_class'     => '',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'link_before'    => '<span>',
						'link_after'     => '</span>',
					)
				);
				?>
			</nav>

			<!-- Header Actions -->
			<div class="site-header__actions">
				<!-- Phone -->
				<a href="tel:+74951176337" class="site-header__phone" title="Позвонить">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="var(--color-primary)"><path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.25 1.01l-2.2 2.2z"/></svg>
					<span>+7 (495) 117-63-37</span>
				</a>

				<!-- CTA Button -->
				<a href="#appointment" class="btn btn-primary"><?php _e( 'Записаться', 'shumoff' ); ?></a>

				<!-- Burger Menu (Mobile) -->
				<button class="burger-menu" id="burger-menu" aria-label="<?php _e( 'Открыть меню', 'shumoff' ); ?>" aria-expanded="false">
					<span></span>
					<span></span>
					<span></span>
				</button>
			</div>

		</div>
	</div>
</header>