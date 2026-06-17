<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Шумофф Подольск — профессиональная шумоизоляция автомобилей.">
    <title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <div class="container">
        <div class="header-inner">
            <div class="header-logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-link">
                    <?php
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        echo '<span class="logo-text">ШУМОФФ</span>';
                    }
                    ?>
                </a>
            </div>

            <nav class="header-nav" id="header-nav">
                <ul class="nav-list">
                    <li><a href="<?php echo esc_url( home_url( '/services' ) ); ?>">Услуги</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/cases' ) ); ?>">Кейсы</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/cars' ) ); ?>">Автомобили</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/prices' ) ); ?>">Цены</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/blog' ) ); ?>">Блог</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/contacts' ) ); ?>">Контакты</a></li>
                </ul>
            </nav>

            <div class="header-actions">
                <div class="header-contacts">
                    <a href="tel:+74951176337" class="header-phone">+7 (495) 117-63-37</a>
                    <div class="header-messengers">
                        <a href="https://wa.me/74951176337" target="_blank" rel="noopener" class="messenger-link messenger--whatsapp" title="WhatsApp">WA</a>
                        <a href="https://t.me/shumoffpodolsk" target="_blank" rel="noopener" class="messenger-link messenger--telegram" title="Telegram">TG</a>
                    </div>
                </div>
                <a href="#contact-form" class="btn btn--primary btn--sm">Записаться</a>
            </div>

            <button class="header-menu-toggle" id="header-menu-toggle" aria-label="Меню">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>

<main class="site-content" id="main-content">
