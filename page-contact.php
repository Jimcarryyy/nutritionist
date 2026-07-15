<?php
/**
 * Template Name: Contact
 *
 * @package nutritionist_theme
 */

get_header();

$badge_path = get_template_directory() . '/assets/images/contact/contact-badge.png';
$badge_ver  = file_exists( $badge_path ) ? (string) filemtime( $badge_path ) : _S_VERSION;

$map_address = nutritionist_theme_get_field(
	'contact_location',
	nutritionist_theme_get_setting( 'footer_location', 'Connaught Place, New Delhi, Delhi 110001, India' )
);
$map_embed_default = 'https://www.google.com/maps?q=' . rawurlencode( $map_address ) . '&z=15&output=embed';
$map_embed         = nutritionist_theme_get_field( 'contact_map_embed', '' );
if ( ! $map_embed ) {
	$map_embed = nutritionist_theme_get_setting( 'map_embed_url', $map_embed_default );
}
if ( ! $map_embed ) {
	$map_embed = $map_embed_default;
}
$map_link = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $map_address );

$email = nutritionist_theme_get_field(
	'contact_email',
	nutritionist_theme_get_setting( 'footer_email', 'support@nutritionist.com' )
);
$phone = nutritionist_theme_get_field(
	'contact_phone',
	nutritionist_theme_get_setting( 'footer_phone', '+91 00000 00000' )
);
$tel   = preg_replace( '/[^\d+]/', '', $phone );

$contact_cards = array(
	array(
		'icon'  => 'fa-envelope',
		'label' => $email,
		'href'  => 'mailto:' . $email,
	),
	array(
		'icon'  => 'fa-phone',
		'label' => $phone,
		'href'  => 'tel:' . $tel,
	),
	array(
		'icon'  => 'fa-location-dot',
		'label' => $map_address,
		'href'  => $map_link,
	),
);

$fb  = nutritionist_theme_get_field( 'contact_social_facebook', nutritionist_theme_get_setting( 'social_facebook', '#' ) );
$tw  = nutritionist_theme_get_field( 'contact_social_twitter', nutritionist_theme_get_setting( 'social_twitter', '#' ) );
$li  = nutritionist_theme_get_field( 'contact_social_linkedin', nutritionist_theme_get_setting( 'social_linkedin', '#' ) );
$socials = array(
	array( 'icon' => 'fa-facebook-f', 'label' => 'Facebook', 'href' => $fb ? $fb : '#' ),
	array( 'icon' => 'fa-x-twitter', 'label' => 'Twitter', 'href' => $tw ? $tw : '#' ),
	array( 'icon' => 'fa-linkedin-in', 'label' => 'LinkedIn', 'href' => $li ? $li : '#' ),
);

$hero_title = nutritionist_theme_get_field( 'contact_hero_title', __( 'Contact Us', 'nutritionist_theme' ) );
$hero_text  = nutritionist_theme_get_field(
	'contact_hero_text',
	__( 'We are here to help you on your journey towards a healthier and happier lifestyle. Get in touch with us for any questions, consultations, or personalized nutrition guidance.', 'nutritionist_theme' )
);
$cta_title  = nutritionist_theme_get_field(
	'contact_cta_title',
	__( 'Are you ready to embark on a transformative journey towards better health and wellness?', 'nutritionist_theme' )
);
$cta_text   = nutritionist_theme_get_field(
	'contact_cta_text',
	__( 'Join us at Nutritionist and let us guide you on the path to a healthier and happier you.', 'nutritionist_theme' )
);
$cta_label  = nutritionist_theme_get_field( 'contact_cta_label', __( 'Join Us Now', 'nutritionist_theme' ) );
$cta_url    = nutritionist_theme_get_field( 'contact_cta_url', home_url( '/pricing/' ) );

$allowed_plans = array( 'Basic Plan', 'Premium Plan', 'Ultimate Plan' );
$plan_param    = isset( $_GET['plan'] ) ? sanitize_text_field( wp_unslash( $_GET['plan'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$billing_param = isset( $_GET['billing'] ) ? sanitize_key( wp_unslash( $_GET['billing'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
if ( ! in_array( $plan_param, $allowed_plans, true ) ) {
	$plan_param = '';
}
if ( ! in_array( $billing_param, array( 'monthly', 'yearly' ), true ) ) {
	$billing_param = $plan_param ? 'monthly' : '';
}
$billing_label = ( 'yearly' === $billing_param ) ? __( 'Yearly', 'nutritionist_theme' ) : __( 'Monthly', 'nutritionist_theme' );
$plan_message  = '';
if ( $plan_param ) {
	$plan_message = sprintf(
		/* translators: 1: plan name, 2: billing period */
		__( "I'm interested in the %1\$s (%2\$s).", 'nutritionist_theme' ),
		$plan_param,
		$billing_label
	);
}
?>

	<main id="primary" class="site-main site-main--contact">

		<section class="contact-hero" id="contact-hero" data-hero-enter>
			<div class="container">
				<div class="contact-hero__panel" data-reveal>
					<div class="contact-hero__dots" aria-hidden="true"></div>
					<img
						class="contact-hero__badge"
						src="<?php echo esc_url( nutritionist_theme_image_url( 'contact/contact-badge.png' ) . '?v=' . rawurlencode( $badge_ver ) ); ?>"
						alt=""
						width="80"
						height="80"
					>
					<h1 class="contact-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
					<p class="contact-hero__text"><?php echo esc_html( $hero_text ); ?></p>

					<div class="contact-hero__bar">
						<?php foreach ( $contact_cards as $card ) : ?>
							<?php if ( $card['href'] ) : ?>
								<a class="contact-hero__card" href="<?php echo esc_url( $card['href'] ); ?>">
									<span class="contact-hero__card-icon" aria-hidden="true"><i class="fa-solid <?php echo esc_attr( $card['icon'] ); ?>"></i></span>
									<span class="contact-hero__card-label"><?php echo esc_html( $card['label'] ); ?></span>
								</a>
							<?php else : ?>
								<div class="contact-hero__card">
									<span class="contact-hero__card-icon" aria-hidden="true"><i class="fa-solid <?php echo esc_attr( $card['icon'] ); ?>"></i></span>
									<span class="contact-hero__card-label"><?php echo esc_html( $card['label'] ); ?></span>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>

		<section class="section section--contact-form" id="contact-form">
			<div class="container">
				<div class="contact-panel" data-reveal>
					<form class="contact-form" action="#" method="post" novalidate>
						<div class="contact-form__status" data-contact-status role="status" aria-live="polite" hidden></div>

						<?php if ( $plan_param ) : ?>
							<div class="contact-form__plan" data-contact-plan-banner>
								<span class="contact-form__plan-label"><?php esc_html_e( 'Selected plan', 'nutritionist_theme' ); ?></span>
								<strong class="contact-form__plan-name" data-contact-plan-label>
									<?php echo esc_html( $plan_param . ' · ' . $billing_label ); ?>
								</strong>
							</div>
						<?php else : ?>
							<div class="contact-form__plan" data-contact-plan-banner hidden>
								<span class="contact-form__plan-label"><?php esc_html_e( 'Selected plan', 'nutritionist_theme' ); ?></span>
								<strong class="contact-form__plan-name" data-contact-plan-label></strong>
							</div>
						<?php endif; ?>

						<input type="hidden" name="plan" value="<?php echo esc_attr( $plan_param ); ?>" data-contact-plan>
						<input type="hidden" name="billing" value="<?php echo esc_attr( $billing_param ); ?>" data-contact-billing>

						<p class="contact-form__honeypot" aria-hidden="true">
							<label>
								<span><?php esc_html_e( 'Leave blank', 'nutritionist_theme' ); ?></span>
								<input type="text" name="nt_hp" value="" tabindex="-1" autocomplete="off" data-contact-honeypot>
							</label>
						</p>

						<div class="contact-form__row">
							<label class="contact-form__field">
								<span class="contact-form__label"><?php esc_html_e( 'Full Name', 'nutritionist_theme' ); ?></span>
								<input type="text" name="full_name" placeholder="<?php esc_attr_e( 'Enter your name', 'nutritionist_theme' ); ?>" required>
							</label>
							<label class="contact-form__field">
								<span class="contact-form__label"><?php esc_html_e( 'Email', 'nutritionist_theme' ); ?></span>
								<input type="email" name="email" placeholder="<?php esc_attr_e( 'Enter your email', 'nutritionist_theme' ); ?>" required>
							</label>
						</div>

						<label class="contact-form__field">
							<span class="contact-form__label"><?php esc_html_e( 'Phone Number', 'nutritionist_theme' ); ?></span>
							<input type="tel" name="phone" placeholder="<?php esc_attr_e( 'Enter your number', 'nutritionist_theme' ); ?>">
						</label>

						<label class="contact-form__field contact-form__field--message">
							<span class="contact-form__label"><?php esc_html_e( 'Message', 'nutritionist_theme' ); ?></span>
							<textarea name="message" maxlength="250" rows="6" placeholder="<?php esc_attr_e( 'Enter your message...', 'nutritionist_theme' ); ?>" required><?php echo esc_textarea( $plan_message ); ?></textarea>
							<span class="contact-form__hint" data-contact-hint><?php esc_html_e( 'Max 250 Chars', 'nutritionist_theme' ); ?></span>
						</label>

						<button type="submit" class="btn btn--primary contact-form__submit">
							<?php esc_html_e( 'Send Message', 'nutritionist_theme' ); ?>
						</button>
					</form>

					<aside class="contact-aside">
						<div class="contact-aside__map-wrap">
							<iframe
								class="contact-aside__map"
								src="<?php echo esc_url( $map_embed ); ?>"
								title="<?php echo esc_attr( sprintf( __( 'Map showing %s', 'nutritionist_theme' ), $map_address ) ); ?>"
								loading="lazy"
								referrerpolicy="no-referrer-when-downgrade"
								allowfullscreen
							></iframe>
						</div>
						<div class="contact-aside__socials">
							<?php foreach ( $socials as $social ) : ?>
								<a class="contact-aside__social" href="<?php echo esc_url( $social['href'] ); ?>" aria-label="<?php echo esc_attr( $social['label'] ); ?>">
									<i class="fa-brands <?php echo esc_attr( $social['icon'] ); ?>" aria-hidden="true"></i>
								</a>
							<?php endforeach; ?>
						</div>
					</aside>
				</div>
			</div>
		</section>

		<section class="section section--contact-cta" id="contact-cta">
			<div class="container">
				<div class="contact-cta is-reveal--scale" data-reveal>
					<img class="contact-cta__decor contact-cta__decor--left" src="<?php echo esc_url( nutritionist_theme_image_url( 'contact/cta-abstract-1.png' ) ); ?>" alt="" width="180" height="120" aria-hidden="true">
					<img class="contact-cta__decor contact-cta__decor--right" src="<?php echo esc_url( nutritionist_theme_image_url( 'contact/cta-abstract-2.png' ) ); ?>" alt="" width="120" height="120" aria-hidden="true">
					<div class="contact-cta__copy">
						<h2 class="contact-cta__title"><?php echo esc_html( $cta_title ); ?></h2>
						<p class="contact-cta__text"><?php echo esc_html( $cta_text ); ?></p>
					</div>
					<a class="btn btn--primary contact-cta__btn" href="<?php echo esc_url( $cta_url ); ?>">
						<?php echo esc_html( $cta_label ); ?>
					</a>
				</div>
			</div>
		</section>

	</main><!-- #main -->

<?php
get_footer();
