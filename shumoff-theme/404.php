<?php
/**
 * The template for displaying 404 Not Found pages.
 *
 * @package Shumoff_Theme
 */

get_header();
?>

<main class="page-content">
	<div class="container">
		<div class="error-page">
			<div class="error-page__title">404</div>
			<h2 class="error-page__heading"><?php _e( '404 — Страница не найдена', 'shumoff' ); ?></h2>
			<p class="error-page__message"><?php _e( 'Страница, которую вы ищете, не существует.', 'shumoff' ); ?></p>

			<!-- Search Form -->
			<div class="error-page__search">
				<?php get_search_form(); ?>
			</div>

			<!-- Back Links -->
			<div class="error-page__actions">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
					<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:8px"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
					<?php _e( 'Вернуться на главную', 'shumoff' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/cases' ) ); ?>" class="btn btn-outline" style="margin-left:12px;">
					<?php _e( 'Смотреть кейсы', 'shumoff' ); ?>
				</a>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
