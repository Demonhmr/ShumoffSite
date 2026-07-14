<footer class="site-footer">
	<div class="container">
		<div class="site-footer__grid">

			<!-- Footer Column 1: Navigation -->
			<div class="site-footer__column">
				<h4><?php _e( 'Навигация', 'shumoff' ); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-menu',
						'menu_id'        => 'footer-menu-items',
						'menu_class'     => '',
						'container'      => false,
						'fallback_cb'    => false,
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'link_before'    => '<span>',
						'link_after'     => '</span>',
					)
				);
				?>
			</div>

			<!-- Footer Column 2: Contacts -->
			<div class="site-footer__column site-footer__contacts">
				<h4><?php _e( 'Контакты', 'shumoff' ); ?></h4>

				<p>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
					<a href="tel:<?php echo esc_attr( shumoff_contact_phone_link() ); ?>"><?php echo esc_html( shumoff_contact( 'contact_phone' ) ); ?></a>
				</p>

				<p>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
					<?php echo esc_html( shumoff_contact( 'contact_address' ) ); ?>
				</p>

				<p>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
					<a href="mailto:<?php echo esc_attr( shumoff_contact( 'contact_email' ) ); ?>"><?php echo esc_html( shumoff_contact( 'contact_email' ) ); ?></a>
				</p>

				<p>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
					<?php echo esc_html( shumoff_contact( 'contact_hours' ) ); ?>
				</p>

				<!-- Social Links -->
				<div class="site-footer__socials">
					<a href="<?php echo esc_url( shumoff_contact( 'contact_whatsapp' ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" title="Написать в WhatsApp">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
					</a>
					<a href="<?php echo esc_url( shumoff_contact( 'contact_telegram' ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Telegram" title="Написать в Telegram">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
					</a>
				</div>
			</div>

			<!-- Footer Column 3: Widget Area -->
			<div class="site-footer__column">
				<h4><?php _e( 'Информация', 'shumoff' ); ?></h4>
				<?php if ( is_active_sidebar( 'sidebar-footer-1' ) ) : ?>
					<?php dynamic_sidebar( 'sidebar-footer-1' ); ?>
				<?php else : ?>
					<ul>
						<li><a href="<?php echo esc_url( get_post_type_archive_link( 'services' ) ); ?>"><?php _e( 'Услуги', 'shumoff' ); ?></a></li>
						<li><a href="<?php echo esc_url( get_post_type_archive_link( 'cases' ) ); ?>"><?php _e( 'Кейсы', 'shumoff' ); ?></a></li>
						<li><a href="<?php echo esc_url( get_post_type_archive_link( 'cars' ) ); ?>"><?php _e( 'Автомобили', 'shumoff' ); ?></a></li>
					</ul>
				<?php endif; ?>
			</div>

		</div>

		<!-- Footer Bottom -->
		<div class="site-footer__bottom">
			<p>
				&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
				<?php _e( 'Все права защищены.', 'shumoff' ); ?>
				<a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><?php _e( 'Политика конфиденциальности', 'shumoff' ); ?></a>
			</p>
		</div>
	</div>
</footer>

<?php get_template_part( 'template-parts/quiz-modal' ); ?>

<!-- ===== Schema.org BreadcrumbList (JSON-LD): тот же источник, что и видимые крошки ===== -->
<?php if ( ! is_front_page() && ! is_404() ) : ?>
	<?php shumoff_print_jsonld( shumoff_schema_breadcrumbs() ); ?>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>