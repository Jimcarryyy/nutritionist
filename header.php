<?php
/**
 * The header for our theme
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package nutritionist_theme
 */

$nutritionist_theme_uri = get_template_directory_uri();
?>
<!doctype html>
<html <?php language_attributes(); ?> class="is-loading">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<script>
	(function () {
		try {
			if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
				document.documentElement.classList.remove( 'is-loading' );
				document.documentElement.classList.add( 'loader-skip' );
			}
		} catch ( e ) {}
	})();
	</script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<div
		id="site-loader"
		class="site-loader"
		role="status"
		aria-live="polite"
		aria-label="<?php esc_attr_e( 'Loading', 'nutritionist_theme' ); ?>"
	>
		<div class="site-loader__brand">
			<img
				class="site-loader__mark"
				src="<?php echo esc_url( $nutritionist_theme_uri . '/assets/images/logo-mark.png' ); ?>"
				alt=""
				width="72"
				height="72"
			>
			<span class="site-loader__name"><?php bloginfo( 'name' ); ?></span>
		</div>
	</div>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'nutritionist_theme' ); ?></a>

	<div class="site-top">
		<div class="site-announcement">
			<div class="site-announcement__inner">
				<img
					class="site-announcement__decor site-announcement__decor--left"
					src="<?php echo esc_url( $nutritionist_theme_uri . '/assets/images/abstract-scribble.png' ); ?>"
					alt=""
					width="196"
					height="44"
					aria-hidden="true"
				>
				<p class="site-announcement__text">
					<img
						class="site-announcement__icon"
						src="<?php echo esc_url( $nutritionist_theme_uri . '/assets/images/announce-icon.png' ); ?>"
						alt=""
						width="24"
						height="24"
					>
					<?php
					$announce_text = nutritionist_theme_get_setting( 'announcement_text', __( 'Join Our Personalized Nutrition Demo For Free', 'nutritionist_theme' ) );
					$announce_url  = nutritionist_theme_get_setting( 'announcement_url', '' );
					?>
					<?php if ( $announce_url ) : ?>
						<a class="site-announcement__link" href="<?php echo esc_url( $announce_url ); ?>">
							<span><?php echo esc_html( $announce_text ); ?></span>
							<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
						</a>
					<?php else : ?>
						<span><?php echo esc_html( $announce_text ); ?></span>
						<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
					<?php endif; ?>
				</p>
				<img
					class="site-announcement__decor site-announcement__decor--right"
					src="<?php echo esc_url( $nutritionist_theme_uri . '/assets/images/abstract-scribble-alt.png' ); ?>"
					alt=""
					width="196"
					height="44"
					aria-hidden="true"
				>
			</div>
		</div>

		<header id="masthead" class="site-header">
			<div class="site-header__inner">
				<div class="site-branding">
					<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img
							class="site-logo__mark"
							src="<?php echo esc_url( $nutritionist_theme_uri . '/assets/images/logo-mark.png' ); ?>"
							alt=""
							width="45"
							height="45"
						>
						<span class="site-logo__text"><?php bloginfo( 'name' ); ?></span>
					</a>
				</div><!-- .site-branding -->

				<div class="site-header__actions">
					<nav id="site-navigation" class="main-navigation">
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
							<span class="screen-reader-text"><?php esc_html_e( 'Primary Menu', 'nutritionist_theme' ); ?></span>
							<span class="menu-toggle__bars" aria-hidden="true">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</button>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
								'container'      => false,
								'fallback_cb'    => 'nutritionist_theme_fallback_menu',
							)
						);
						?>
					</nav><!-- #site-navigation -->

					<a class="site-header__cta btn btn--primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
						<?php esc_html_e( 'Contact Us', 'nutritionist_theme' ); ?>
					</a>
				</div>
			</div>
		</header><!-- #masthead -->
	</div><!-- .site-top -->
