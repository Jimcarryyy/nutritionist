<?php
/**
 * Template part: Pricing section
 *
 * @package nutritionist_theme
 */

$front_id = nutritionist_theme_get_front_page_id();
$pid      = $front_id ? $front_id : null;

$defaults = array(
	array(
		'name'        => __( 'Basic Plan', 'nutritionist_theme' ),
		'price'       => 49,
		'description' => __( 'Get started on your health journey with our Basic Plan. It includes personalized nutrition coaching, access to our app, meal planning assistance, and email support.', 'nutritionist_theme' ),
		'cta_label'   => __( 'Choose Plan', 'nutritionist_theme' ),
		'cta_url'     => home_url( '/contact/' ),
	),
	array(
		'name'        => __( 'Premium Plan', 'nutritionist_theme' ),
		'price'       => 79,
		'description' => __( 'Upgrade to our Premium Plan for enhanced features. In addition to the Basic Plan, you\'ll receive video consultations, priority support, and personalized recipe recommendations.', 'nutritionist_theme' ),
		'cta_label'   => __( 'Choose Plan', 'nutritionist_theme' ),
		'cta_url'     => home_url( '/contact/' ),
	),
	array(
		'name'        => __( 'Ultimate Plan', 'nutritionist_theme' ),
		'price'       => 99,
		'description' => __( 'Experience the full benefits of personalized nutrition coaching with our Ultimate Plan. Enjoy all the features of the Premium Plan, along with 24/7 chat support and exclusive workshops.', 'nutritionist_theme' ),
		'cta_label'   => __( 'Choose Plan', 'nutritionist_theme' ),
		'cta_url'     => home_url( '/contact/' ),
	),
);

$plans = nutritionist_theme_collect_groups(
	'home_plan',
	3,
	static function ( $group ) {
		$name = isset( $group['name'] ) ? trim( (string) $group['name'] ) : '';
		if ( '' === $name ) {
			return null;
		}
		return array(
			'name'        => $name,
			'price'       => isset( $group['price'] ) ? (float) $group['price'] : 0,
			'description' => isset( $group['description'] ) ? (string) $group['description'] : '',
			'cta_label'   => ! empty( $group['cta_label'] ) ? $group['cta_label'] : __( 'Choose Plan', 'nutritionist_theme' ),
			'cta_url'     => ! empty( $group['cta_url'] ) ? $group['cta_url'] : home_url( '/contact/' ),
		);
	},
	$defaults,
	$pid
);

$section_title = nutritionist_theme_get_field( 'home_pricing_title', __( 'Our Pricing', 'nutritionist_theme' ), $pid );
$section_intro = nutritionist_theme_get_field(
	'home_pricing_intro',
	__( 'We outline our flexible and affordable options to support you on your journey to optimal health and nutrition. We believe that everyone deserves access to personalized nutrition guidance and resources', 'nutritionist_theme' ),
	$pid
);
?>

<section class="section section--pricing" id="pricing">
	<div class="container">
		<header class="section__header">
			<h2 class="section__title"><?php echo esc_html( $section_title ); ?></h2>
			<p class="section__intro"><?php echo esc_html( $section_intro ); ?></p>
		</header>

		<div class="pricing-toggle-wrap">
			<div class="pricing-toggle" data-pricing-toggle role="group" aria-label="<?php esc_attr_e( 'Billing period', 'nutritionist_theme' ); ?>">
				<button type="button" class="pricing-toggle__btn is-active" data-billing="monthly" aria-pressed="true">
					<?php esc_html_e( 'Monthly', 'nutritionist_theme' ); ?>
				</button>
				<button type="button" class="pricing-toggle__btn" data-billing="yearly" aria-pressed="false">
					<?php esc_html_e( 'Yearly', 'nutritionist_theme' ); ?>
				</button>
			</div>
			<p class="pricing-toggle__save"><?php esc_html_e( 'Save 50% on Yearly', 'nutritionist_theme' ); ?></p>
		</div>

		<div class="pricing-grid" data-reveal-stagger>
			<?php foreach ( $plans as $plan ) : ?>
				<article class="pricing-card" data-reveal data-monthly-price="<?php echo esc_attr( (string) $plan['price'] ); ?>">
					<h3 class="pricing-card__name"><?php echo esc_html( $plan['name'] ); ?></h3>
					<p class="pricing-card__discount"><?php esc_html_e( 'Up to 50% off on Yearly Plan', 'nutritionist_theme' ); ?></p>
					<p class="pricing-card__text"><?php echo esc_html( $plan['description'] ); ?></p>
					<p class="pricing-card__price">
						<span class="pricing-card__amount" data-price-amount>$<?php echo esc_html( (string) $plan['price'] ); ?></span>
						<span class="pricing-card__period" data-price-period><?php esc_html_e( '/month', 'nutritionist_theme' ); ?></span>
					</p>
					<a
						class="btn btn--primary pricing-card__cta"
						href="<?php echo esc_url( add_query_arg( array( 'plan' => $plan['name'], 'billing' => 'monthly' ), home_url( '/contact/' ) ) ); ?>"
						data-plan-cta
						data-plan-name="<?php echo esc_attr( $plan['name'] ); ?>"
					>
						<?php echo esc_html( $plan['cta_label'] ); ?>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
