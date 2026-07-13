<?php
/**
 * Appointment form section.
 *
 * Accepts $args:
 *  - title: заголовок секции
 *  - text:  подводка под заголовком
 *
 * @package Shumoff_Theme
 */

$appt_title = ! empty( $args['title'] ) ? $args['title'] : __( 'Рассчитайте стоимость шумоизоляции', 'shumoff' );
$appt_text  = ! empty( $args['text'] ) ? $args['text'] : __( 'Оставьте заявку и наш менеджер свяжется с вами в течение 15 минут для расчёта стоимости.', 'shumoff' );
?>
<section class="appointment-section section" id="appointment" aria-label="Форма заявки">
	<div class="container">
		<div class="appointment-section__inner">
			<div class="appointment-section__content">
				<h2 class="appointment-section__title"><?php echo esc_html( $appt_title ); ?></h2>
				<p class="appointment-section__text"><?php echo esc_html( $appt_text ); ?></p>
				<ul class="appointment-section__benefits">
					<li><?php _e( 'Бесплатная консультация', 'shumoff' ); ?></li>
					<li><?php _e( 'Индивидуальный расчёт', 'shumoff' ); ?></li>
					<li><?php _e( 'Скидка 5% при записи онлайн', 'shumoff' ); ?></li>
				</ul>
			</div>

			<div class="appointment-section__form">
				<form class="appointment-form" method="post" action="<?php echo esc_url( home_url( '/' ) ); ?>" data-validate novalidate>
					<div class="form-group">
						<label for="appt-name"><?php _e( 'Ваше имя', 'shumoff' ); ?> <span class="required">*</span></label>
						<input type="text" id="appt-name" name="appt_name" placeholder="<?php esc_attr_e( 'Иван Иванов', 'shumoff' ); ?>" required>
						<span class="form__error" data-error-for="name"><?php _e( 'Укажите ваше имя', 'shumoff' ); ?></span>
					</div>

					<div class="form-group">
						<label for="appt-phone"><?php _e( 'Телефон', 'shumoff' ); ?> <span class="required">*</span></label>
						<input type="tel" id="appt-phone" name="appt_phone" placeholder="+7 (___) ___-__-__" data-validate-phone required>
						<span class="form__error" data-error-for="phone"><?php _e( 'Укажите корректный номер телефона', 'shumoff' ); ?></span>
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
						<button type="submit" class="btn btn-primary btn--lg btn--block"><?php _e( 'Рассчитать', 'shumoff' ); ?></button>
					</div>

					<p class="appointment-form__privacy">
						<?php _e( 'Нажимая кнопку, вы соглашаетесь с', 'shumoff' ); ?> <a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><?php _e( 'политикой конфиденциальности', 'shumoff' ); ?></a>.
					</p>
				</form>
			</div>
		</div>
	</div>
</section>
