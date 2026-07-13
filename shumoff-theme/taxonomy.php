<?php
/**
 * Шаблон архивов таксономий car_brand (/brand/…) и case_type (/work-type/…).
 * В выдаче смешаны типы записей (авто, кейсы, услуги) — карточка помечается
 * типом и показывает свою ключевую метаинформацию.
 *
 * @package Shumoff_Theme
 */

get_header();

$shumoff_term = get_queried_object();
?>

<main class="page-content">
	<section class="archive-section section section--dark">
		<div class="container">
			<h1 class="section-title text-center"><?php echo esc_html( $shumoff_term->name ); ?></h1>
			<p class="section-subtitle text-center">
				<?php
				if ( is_tax( 'car_brand' ) ) {
					printf( __( 'Шумоизоляция автомобилей %s: цены и выполненные работы', 'shumoff' ), esc_html( $shumoff_term->name ) );
				} elseif ( is_tax( 'case_type' ) ) {
					printf( __( 'Работы и услуги: %s', 'shumoff' ), esc_html( $shumoff_term->name ) );
				} elseif ( ! empty( $shumoff_term->description ) ) {
					echo esc_html( $shumoff_term->description );
				}
				?>
			</p>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<?php if ( have_posts() ) : ?>
				<div class="cases-grid">
					<?php
					$shumoff_type_labels = array(
						'cars'     => __( 'Автомобиль', 'shumoff' ),
						'cases'    => __( 'Кейс', 'shumoff' ),
						'services' => __( 'Услуга', 'shumoff' ),
					);
					while ( have_posts() ) :
						the_post();
						$shumoff_post_type = get_post_type();

						// Ключевая цена для карточки в зависимости от типа записи.
						$shumoff_card_price = '';
						if ( 'cases' === $shumoff_post_type ) {
							$shumoff_card_price = shumoff_field( 'case_price' );
						} elseif ( 'cars' === $shumoff_post_type ) {
							$shumoff_card_price = shumoff_field( 'car_full_price' );
						} elseif ( 'services' === $shumoff_post_type ) {
							$shumoff_card_price = shumoff_field( 'service_price_from' );
						}
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
								<?php if ( isset( $shumoff_type_labels[ $shumoff_post_type ] ) ) : ?>
									<span class="entry-term"><?php echo esc_html( $shumoff_type_labels[ $shumoff_post_type ] ); ?></span>
								<?php endif; ?>
								<h2 class="case-card__title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h2>
								<p class="case-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
								<?php if ( $shumoff_card_price ) : ?>
									<span class="case-card__price"><?php printf( __( 'от %s ₽', 'shumoff' ), esc_html( $shumoff_card_price ) ); ?></span>
								<?php endif; ?>
								<a href="<?php the_permalink(); ?>" class="case-card__link"><?php _e( 'Подробнее →', 'shumoff' ); ?></a>
							</div>
						</article>
					<?php endwhile; ?>
				</div>

				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 2,
						'prev_text' => '&laquo; ' . __( 'Назад', 'shumoff' ),
						'next_text' => __( 'Вперёд', 'shumoff' ) . ' &raquo;',
					)
				);
				?>
			<?php else : ?>
				<p class="text-center"><?php _e( 'В этом разделе пока нет материалов.', 'shumoff' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/appointment-form' ); ?>
</main>

<?php get_footer(); ?>
