<?php
/**
 * The template for displaying the footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package nutritionist_theme
 */

$nutritionist_theme_uri = get_template_directory_uri();
?>

	<footer id="colophon" class="site-footer">
		<div class="site-footer__inner">
			<div class="site-footer__top">
				<a class="site-logo site-logo--footer" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img
						class="site-logo__mark"
						src="<?php echo esc_url( $nutritionist_theme_uri . '/assets/images/logo-mark.png' ); ?>"
						alt=""
						width="45"
						height="45"
					>
					<span class="site-logo__text"><?php bloginfo( 'name' ); ?></span>
				</a>

				<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer', 'nutritionist_theme' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_id'        => 'footer-menu',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => 'nutritionist_theme_fallback_footer_menu',
						)
					);
					?>
				</nav>

				<a class="site-footer__totop" href="#page">
					<span class="site-footer__totop-label"><?php esc_html_e( 'Go To Top', 'nutritionist_theme' ); ?></span>
					<span class="site-footer__totop-btn" aria-hidden="true">
						<i class="fa-solid fa-arrow-up"></i>
					</span>
				</a>
			</div>

			<?php
			$footer_email    = nutritionist_theme_get_setting( 'footer_email', 'hello@squareup.com' );
			$footer_phone    = nutritionist_theme_get_setting( 'footer_phone', '+91 91813 23 2309' );
			$footer_location = nutritionist_theme_get_setting( 'footer_location', __( 'Somewhere in the World', 'nutritionist_theme' ) );
			$footer_tel      = preg_replace( '/[^\d+]/', '', $footer_phone );
			?>
			<div class="site-footer__bar">
				<div class="site-footer__contact">
					<a class="site-footer__contact-item" href="<?php echo esc_url( 'mailto:' . $footer_email ); ?>">
						<span class="site-footer__contact-icon" aria-hidden="true"><i class="fa-solid fa-envelope"></i></span>
						<span><?php echo esc_html( $footer_email ); ?></span>
					</a>
					<a class="site-footer__contact-item" href="<?php echo esc_url( 'tel:' . $footer_tel ); ?>">
						<span class="site-footer__contact-icon" aria-hidden="true"><i class="fa-solid fa-phone"></i></span>
						<span><?php echo esc_html( $footer_phone ); ?></span>
					</a>
					<p class="site-footer__contact-item">
						<span class="site-footer__contact-icon" aria-hidden="true"><i class="fa-solid fa-location-dot"></i></span>
						<span><?php echo esc_html( $footer_location ); ?></span>
					</p>
				</div>

				<p class="site-info">
					&copy; 2023
					<?php bloginfo( 'name' ); ?>.
					<?php esc_html_e( 'All rights reserved.', 'nutritionist_theme' ); ?>
				</p>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

	<div
		id="cookie-consent"
		class="cookie-consent"
		role="dialog"
		aria-modal="false"
		aria-labelledby="cookie-consent-title"
		aria-describedby="cookie-consent-text"
		hidden
		data-cookie-consent
	>
		<div class="cookie-consent__panel">
			<div class="cookie-consent__copy">
				<p class="cookie-consent__title" id="cookie-consent-title">
					<?php esc_html_e( 'We use cookies', 'nutritionist_theme' ); ?>
				</p>
				<p class="cookie-consent__text" id="cookie-consent-text">
					<?php
					esc_html_e(
						'This demo site uses cookies to remember preferences and improve your browsing experience. Accept to continue — your choice is stored locally in this browser.',
						'nutritionist_theme'
					);
					?>
				</p>
			</div>
			<div class="cookie-consent__actions">
				<button type="button" class="btn cookie-consent__btn cookie-consent__btn--ghost" data-cookie-decline>
					<?php esc_html_e( 'Decline', 'nutritionist_theme' ); ?>
				</button>
				<button type="button" class="btn btn--primary cookie-consent__btn" data-cookie-accept>
					<?php esc_html_e( 'Accept cookies', 'nutritionist_theme' ); ?>
				</button>
			</div>
		</div>
	</div>

<?php wp_footer(); ?>

</body>
</html>
