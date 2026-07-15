<?php
/**
 * Template part: Hero section
 *
 * @package nutritionist_theme
 */

$front_id = nutritionist_theme_get_front_page_id();
$pid      = $front_id ? $front_id : null;

$hero_title      = nutritionist_theme_get_field( 'home_hero_title', __( 'Personalized Nutrition Coaching', 'nutritionist_theme' ), $pid );
$hero_text       = nutritionist_theme_get_field(
	'home_hero_text',
	__( 'Welcome to Nutritionist, your partner in achieving optimal health through personalized nutrition coaching. Our certified nutritionists are here to guide you on your weight loss journey, providing customized plans and ongoing support. Start your transformation today and experience the power of personalized nutrition coaching.', 'nutritionist_theme' ),
	$pid
);
$cta_primary     = nutritionist_theme_get_field( 'home_hero_cta_primary_label', __( 'Get Starter Today', 'nutritionist_theme' ), $pid );
$cta_primary_url = nutritionist_theme_get_field( 'home_hero_cta_primary_url', home_url( '/contact/' ), $pid );
$cta_secondary   = nutritionist_theme_get_field( 'home_hero_cta_secondary_label', __( 'Book a Demo', 'nutritionist_theme' ), $pid );
$cta_secondary_u = nutritionist_theme_get_field( 'home_hero_cta_secondary_url', home_url( '/pricing/' ), $pid );
$customers_num   = nutritionist_theme_get_field( 'home_hero_customers', '430+', $pid );
$customers_label = nutritionist_theme_get_field( 'home_hero_customers_label', __( 'Happy Customers', 'nutritionist_theme' ), $pid );
$hero_image      = nutritionist_theme_get_field( 'home_hero_image', null, $pid );
$hero_src        = nutritionist_theme_media_src( $hero_image, 'hero-woman.png' );
$hero_img_path   = get_template_directory() . '/assets/images/hero-woman.png';
$hero_ver        = file_exists( $hero_img_path ) ? (string) filemtime( $hero_img_path ) : _S_VERSION;
if ( ! $hero_image ) {
	$hero_src .= '?v=' . rawurlencode( $hero_ver );
}
$eyebrow = nutritionist_theme_get_field( 'home_hero_eyebrow', '', $pid );
?>

<section class="section section--hero" id="hero" data-hero-enter>
	<div class="hero">
		<div class="hero__media">
			<img
				class="hero__image"
				src="<?php echo esc_url( $hero_src ); ?>"
				alt="<?php esc_attr_e( 'Smiling woman in athletic wear pointing toward personalized coaching', 'nutritionist_theme' ); ?>"
				width="949"
				height="832"
			>
		</div>

		<div class="hero__copy">
			<div class="hero__social-proof hero__social-proof--mobile">
				<div class="hero__avatars" aria-hidden="true">
					<img src="<?php echo esc_url( nutritionist_theme_image_url( 'avatars/customer-1.png' ) ); ?>" alt="" width="50" height="50">
					<img src="<?php echo esc_url( nutritionist_theme_image_url( 'avatars/customer-2.png' ) ); ?>" alt="" width="50" height="50">
					<img src="<?php echo esc_url( nutritionist_theme_image_url( 'avatars/customer-3.png' ) ); ?>" alt="" width="50" height="50">
				</div>
				<p class="hero__customers"><strong><?php echo esc_html( $customers_num ); ?></strong> <?php echo esc_html( $customers_label ); ?></p>
			</div>

			<p class="hero__eyebrow">
				<?php
				if ( $eyebrow ) {
					echo esc_html( $eyebrow );
				} else {
					echo wp_kses(
						sprintf(
							/* translators: 1: heart icon markup */
							__( 'Transform Your %1$s <span class="hero__underline">Health with</span>', 'nutritionist_theme' ),
							'<span class="hero__heart" aria-hidden="true">❤️</span>'
						),
						array(
							'span' => array(
								'class'       => true,
								'aria-hidden' => true,
							),
						)
					);
				}
				?>
			</p>
			<h1 class="hero__title"><?php echo esc_html( $hero_title ); ?></h1>
			<p class="hero__text"><?php echo esc_html( $hero_text ); ?></p>
			<div class="hero__actions">
				<a class="btn btn--primary" href="<?php echo esc_url( $cta_primary_url ); ?>">
					<?php echo esc_html( $cta_primary ); ?>
				</a>
				<a class="btn btn--secondary" href="<?php echo esc_url( $cta_secondary_u ); ?>">
					<?php echo esc_html( $cta_secondary ); ?>
				</a>
			</div>

			<div class="hero__social-proof hero__social-proof--desktop">
				<div class="hero__avatars" aria-hidden="true">
					<img src="<?php echo esc_url( nutritionist_theme_image_url( 'avatars/customer-1.png' ) ); ?>" alt="" width="50" height="50">
					<img src="<?php echo esc_url( nutritionist_theme_image_url( 'avatars/customer-2.png' ) ); ?>" alt="" width="50" height="50">
					<img src="<?php echo esc_url( nutritionist_theme_image_url( 'avatars/customer-3.png' ) ); ?>" alt="" width="50" height="50">
				</div>
				<p class="hero__customers"><strong><?php echo esc_html( $customers_num ); ?></strong> <?php echo esc_html( $customers_label ); ?></p>
			</div>
		</div>
	</div>
</section>
