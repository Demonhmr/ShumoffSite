<?php
/**
 * Квиз-калькулятор: попап на всех страницах (ТЗ: docs/quiz_calculator.md).
 * Открывается кнопками с атрибутом data-quiz-open, логика — assets/js/quiz.js,
 * данные и приём лида — плагин shumoff-core (includes/quiz.php).
 *
 * @package Shumoff_Theme
 */

if ( ! function_exists( 'shumoff_quiz_config' ) ) {
	return; // Плагин shumoff-core выключен — квиз недоступен.
}

$quiz_classes  = shumoff_quiz_classes();
$quiz_concerns = shumoff_quiz_concerns();
$quiz_packages = shumoff_quiz_packages();
$quiz_brands   = shumoff_quiz_brands();

$quiz_class_icons = array(
	'sedan'      => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 24 l4 -8 q2 -3 6 -3 h20 q4 0 7 3 l5 5 h8 q3 0 3 3 v0 h-6"/><circle cx="18" cy="25" r="4"/><circle cx="46" cy="25" r="4"/><path d="M22 25 h20"/><path d="M6 24 h8"/></svg>',
	'crossover'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 23 l3 -9 q2 -4 7 -4 h22 q5 0 8 4 l4 5 h6 q4 0 4 4 h-5"/><circle cx="17" cy="24" r="4.5"/><circle cx="47" cy="24" r="4.5"/><path d="M22 24 h20"/></svg>',
	'suv'        => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22 v-10 q0 -3 3 -3 h30 q4 0 7 3 l6 6 h6 q4 0 4 4 h-5"/><circle cx="16" cy="24" r="5"/><circle cx="47" cy="24" r="5"/><path d="M21 24 h21"/><path d="M4 22 h7"/></svg>',
	'commercial' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 24 v-16 q0 -2 2 -2 h34 q2 0 2 2 v16"/><path d="M42 12 h10 l6 6 v6 h-4"/><circle cx="15" cy="25" r="4"/><circle cx="49" cy="25" r="4"/><path d="M19 25 h26"/><path d="M4 24 h7"/></svg>',
);
?>
<div class="quiz-modal" id="quiz-modal" hidden>
	<div class="quiz-modal__overlay" data-quiz-close></div>
	<div class="quiz-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="quiz-modal-title">
		<button type="button" class="quiz-modal__close" data-quiz-close aria-label="<?php esc_attr_e( 'Закрыть', 'shumoff' ); ?>">&times;</button>

		<div class="quiz-modal__header">
			<p class="quiz-modal__bonus"><?php _e( 'Скидка 10% на материалы + бесплатный замер уровня шума', 'shumoff' ); ?></p>
			<h2 class="quiz-modal__title" id="quiz-modal-title"><?php _e( 'Рассчитайте стоимость шумоизоляции для вашего авто за 1 минуту', 'shumoff' ); ?></h2>
			<div class="quiz-progress" aria-hidden="true"><span class="quiz-progress__bar" data-quiz-progress></span></div>
			<p class="quiz-progress__caption"><?php _e( 'Шаг', 'shumoff' ); ?> <span data-quiz-step-current>1</span> / 5</p>
		</div>

		<form class="quiz-form" data-quiz-form method="post" novalidate>
			<?php wp_nonce_field( 'shumoff_quiz', 'shumoff_quiz_nonce' ); ?>
			<input type="hidden" name="quiz_page" value="">
			<input type="hidden" name="quiz_utm" value="">

			<!-- Honeypot: скрыто стилями; имя и подпись не похожи на поля профиля. -->
			<div class="form-group form-group--hp" aria-hidden="true">
				<label for="quiz-extra"><?php _e( 'Оставьте это поле пустым', 'shumoff' ); ?></label>
				<input type="text" id="quiz-extra" name="quiz_extra" tabindex="-1" autocomplete="one-time-code">
			</div>

			<!-- Шаг 1: класс автомобиля -->
			<fieldset class="quiz-step" data-quiz-step="1">
				<legend class="quiz-step__question"><?php _e( 'Какой у вас класс автомобиля?', 'shumoff' ); ?></legend>
				<div class="quiz-options quiz-options--cards">
					<?php foreach ( $quiz_classes as $quiz_key => $quiz_class ) : ?>
						<label class="quiz-option quiz-option--card">
							<input type="radio" name="quiz_class" value="<?php echo esc_attr( $quiz_key ); ?>" required>
							<span class="quiz-option__icon"><?php echo $quiz_class_icons[ $quiz_key ] ?? ''; // статичный SVG из этого файла ?></span>
							<span class="quiz-option__label"><?php echo esc_html( $quiz_class['label'] ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>
			</fieldset>

			<!-- Шаг 2: марка и модель -->
			<fieldset class="quiz-step" data-quiz-step="2" hidden>
				<legend class="quiz-step__question"><?php _e( 'Марка и модель вашего автомобиля?', 'shumoff' ); ?></legend>
				<div class="form-group">
					<label for="quiz-brand"><?php _e( 'Марка', 'shumoff' ); ?> <span class="required">*</span></label>
					<select id="quiz-brand" name="quiz_brand" required>
						<option value=""><?php _e( 'Выберите марку', 'shumoff' ); ?></option>
						<?php foreach ( $quiz_brands as $quiz_brand ) : ?>
							<option value="<?php echo esc_attr( $quiz_brand ); ?>"><?php echo esc_html( $quiz_brand ); ?></option>
						<?php endforeach; ?>
						<option value="other"><?php _e( 'Другая', 'shumoff' ); ?></option>
					</select>
				</div>
				<div class="form-group">
					<label for="quiz-model"><?php _e( 'Модель', 'shumoff' ); ?></label>
					<input type="text" id="quiz-model" name="quiz_model" placeholder="<?php esc_attr_e( 'Например: Rio', 'shumoff' ); ?>">
				</div>
			</fieldset>

			<!-- Шаг 3: что беспокоит (мультивыбор) -->
			<fieldset class="quiz-step" data-quiz-step="3" hidden>
				<legend class="quiz-step__question"><?php _e( 'Что вас больше всего беспокоит?', 'shumoff' ); ?> <small><?php _e( '(можно выбрать несколько)', 'shumoff' ); ?></small></legend>
				<div class="quiz-options">
					<?php foreach ( $quiz_concerns as $quiz_key => $quiz_concern ) : ?>
						<label class="quiz-option">
							<input type="checkbox" name="quiz_concerns[]" value="<?php echo esc_attr( $quiz_key ); ?>">
							<span class="quiz-option__label"><?php echo esc_html( $quiz_concern['label'] ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>
			</fieldset>

			<!-- Шаг 4: ожидаемый результат -->
			<fieldset class="quiz-step" data-quiz-step="4" hidden>
				<legend class="quiz-step__question"><?php _e( 'Какой результат вы ожидаете?', 'shumoff' ); ?></legend>
				<div class="quiz-options">
					<?php foreach ( $quiz_packages as $quiz_key => $quiz_package ) : ?>
						<label class="quiz-option quiz-option--stacked">
							<input type="radio" name="quiz_package" value="<?php echo esc_attr( $quiz_key ); ?>" required>
							<span class="quiz-option__label">
								<strong><?php echo esc_html( $quiz_package['label'] ); ?></strong>
								<small><?php echo esc_html( $quiz_package['note'] ); ?></small>
							</span>
						</label>
					<?php endforeach; ?>
				</div>
			</fieldset>

			<!-- Шаг 5: смета и контакты -->
			<fieldset class="quiz-step" data-quiz-step="5" hidden>
				<legend class="quiz-step__question" data-quiz-final-title><?php _e( 'Отлично! Мы уже делаем предварительный расчёт.', 'shumoff' ); ?></legend>

				<div class="quiz-estimate" data-quiz-estimate hidden>
					<p class="quiz-estimate__row"><?php _e( 'Предварительная стоимость:', 'shumoff' ); ?> <s data-quiz-estimate-total></s></p>
					<p class="quiz-estimate__row quiz-estimate__row--final"><?php _e( 'Со скидкой 10% на материалы:', 'shumoff' ); ?> <strong data-quiz-estimate-final></strong></p>
					<p class="quiz-estimate__note"><?php _e( 'Точная смета фиксируется после бесплатного осмотра и не меняется в процессе работ.', 'shumoff' ); ?></p>
				</div>
				<div class="quiz-estimate" data-quiz-estimate-fallback hidden>
					<p class="quiz-estimate__note"><?php _e( 'Для выбранных работ стоимость рассчитывается после осмотра — мастер осмотрит салон и назовёт точную цену. Скидка 10% уже закреплена за вами.', 'shumoff' ); ?></p>
				</div>

				<p class="quiz-step__lead"><?php _e( 'Куда отправить стоимость работ, сроки и закрепить скидку 10%?', 'shumoff' ); ?></p>

				<div class="quiz-options quiz-options--messenger">
					<label class="quiz-option quiz-option--inline">
						<input type="radio" name="quiz_messenger" value="whatsapp" checked>
						<span class="quiz-option__label">WhatsApp</span>
					</label>
					<label class="quiz-option quiz-option--inline">
						<input type="radio" name="quiz_messenger" value="telegram">
						<span class="quiz-option__label">Telegram</span>
					</label>
					<label class="quiz-option quiz-option--inline">
						<input type="radio" name="quiz_messenger" value="call">
						<span class="quiz-option__label"><?php _e( 'Жду звонка', 'shumoff' ); ?></span>
					</label>
				</div>

				<div class="form-group">
					<label for="quiz-phone"><?php _e( 'Телефон', 'shumoff' ); ?> <span class="required">*</span></label>
					<input type="tel" id="quiz-phone" name="quiz_phone" placeholder="+7 (___) ___-__-__" data-validate-phone required>
					<span class="form__error" data-error-for="phone"><?php _e( 'Укажите корректный номер телефона', 'shumoff' ); ?></span>
				</div>

				<label class="quiz-consent">
					<input type="checkbox" name="quiz_consent" value="1" checked required>
					<span><?php _e( 'Согласен с', 'shumoff' ); ?> <a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>" target="_blank" rel="noopener"><?php _e( 'политикой обработки персональных данных', 'shumoff' ); ?></a></span>
				</label>
			</fieldset>

			<div class="quiz-nav">
				<button type="button" class="btn btn-outline" data-quiz-prev hidden><?php _e( '← Назад', 'shumoff' ); ?></button>
				<button type="button" class="btn btn-primary" data-quiz-next><?php _e( 'Далее →', 'shumoff' ); ?></button>
				<button type="submit" class="btn btn-primary btn--lg" data-quiz-submit hidden><?php _e( 'Получить расчёт и скидку', 'shumoff' ); ?></button>
			</div>

			<p class="quiz-form__status" role="status" aria-live="polite"></p>
		</form>

		<div class="quiz-success" data-quiz-success hidden>
			<div class="quiz-success__icon" aria-hidden="true">✓</div>
			<h3><?php _e( 'Заявка принята!', 'shumoff' ); ?></h3>
			<p><?php _e( 'Скидка 10% закреплена. Мы отправим расчёт и свяжемся с вами в ближайшее время.', 'shumoff' ); ?></p>
			<button type="button" class="btn btn-outline" data-quiz-close><?php _e( 'Закрыть', 'shumoff' ); ?></button>
		</div>
	</div>
</div>
