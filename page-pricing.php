<?php
/**
 * Template Name: Pricing
 *
 * @package nutritionist_theme
 */

get_header();

$plan_defaults = array(
	array(
		'name'     => __( 'Basic Plan', 'nutritionist_theme' ),
		'price'    => 49,
		'features' => array(
			__( 'Personalized nutrition plan tailored to your goals and dietary preferences.', 'nutritionist_theme' ),
			__( 'Access to our mobile app for convenient meal tracking and reminders.', 'nutritionist_theme' ),
			__( 'Email support for any questions or concerns you may have.', 'nutritionist_theme' ),
			__( 'Regular check-ins to keep you accountable and motivated.', 'nutritionist_theme' ),
		),
		'note'     => '',
	),
	array(
		'name'     => __( 'Premium Plan', 'nutritionist_theme' ),
		'price'    => 79,
		'features' => array(
			__( 'All the features included in the Basic Plan.', 'nutritionist_theme' ),
			__( 'One-on-one video consultations with our experienced nutritionists.', 'nutritionist_theme' ),
			__( 'Recipe recommendations and meal planning assistance.', 'nutritionist_theme' ),
			__( 'Priority email support for quicker responses when you need help.', 'nutritionist_theme' ),
			__( 'Educational resources and guides to deepen your understanding of nutrition.', 'nutritionist_theme' ),
		),
		'note'     => '',
	),
	array(
		'name'     => __( 'Ultimate Plan', 'nutritionist_theme' ),
		'price'    => 99,
		'features' => array(
			__( 'All the features included in the Plus Plan.', 'nutritionist_theme' ),
			__( 'Unlimited access to video consultations with your dedicated nutritionist.', 'nutritionist_theme' ),
			__( 'Advanced progress tracking tools to monitor your journey closely.', 'nutritionist_theme' ),
			__( 'Customized meal plans and recipe suggestions based on your preferences.', 'nutritionist_theme' ),
			__( 'Priority email and phone support for continuous guidance.', 'nutritionist_theme' ),
		),
		'note'     => __( 'The Premium Plan is designed for individuals who are committed to achieving significant results and require the highest level of support and personalization.', 'nutritionist_theme' ),
	),
);

$plans = nutritionist_theme_collect_groups(
	'pricing_plan',
	3,
	static function ( $group, $i ) use ( $plan_defaults ) {
		$name = isset( $group['name'] ) ? trim( (string) $group['name'] ) : '';
		if ( '' === $name ) {
			return null;
		}
		$fallback = isset( $plan_defaults[ $i - 1 ] ) ? $plan_defaults[ $i - 1 ] : $plan_defaults[0];
		$features = ! empty( $group['features'] ) ? nutritionist_theme_lines_to_array( $group['features'] ) : $fallback['features'];
		return array(
			'name'     => $name,
			'price'    => isset( $group['price'] ) && '' !== $group['price'] ? (float) $group['price'] : $fallback['price'],
			'features' => $features,
			'note'     => isset( $group['note'] ) ? (string) $group['note'] : $fallback['note'],
		);
	},
	$plan_defaults
);

$compare_headers = array(
	__( 'Features', 'nutritionist_theme' ),
	__( 'Basic Plan', 'nutritionist_theme' ),
	__( 'Premium Plan', 'nutritionist_theme' ),
	__( 'Ultimate Plan', 'nutritionist_theme' ),
);
$header_raw = nutritionist_theme_get_field( 'pricing_compare_headers', '' );
if ( $header_raw ) {
	$parsed_headers = array_map( 'trim', explode( '|', $header_raw ) );
	if ( count( $parsed_headers ) >= 4 ) {
		$compare_headers = array_slice( $parsed_headers, 0, 4 );
	}
}

$compare_rows = array(
	array( __( 'Personalized Nutrition Plan', 'nutritionist_theme' ), true, true, true ),
	array( __( 'Mobile App Access', 'nutritionist_theme' ), true, true, true ),
	array( __( 'Email Support', 'nutritionist_theme' ), true, true, true ),
	array( __( 'One-on-One Video Consultations', 'nutritionist_theme' ), false, true, true ),
	array( __( 'Recipe Recommendations and Meal Planning', 'nutritionist_theme' ), false, true, true ),
	array( __( 'Priority Support', 'nutritionist_theme' ), false, true, true ),
	array( __( 'Educational Resources and Guides', 'nutritionist_theme' ), false, true, true ),
	array( __( 'Advanced Progress Tracking Tools', 'nutritionist_theme' ), false, false, true ),
	array( __( 'Customized Meal Plans and Recipe Suggestions', 'nutritionist_theme' ), false, false, true ),
	array( __( 'Phone Support', 'nutritionist_theme' ), false, false, true ),
);
$compare_raw = nutritionist_theme_get_field( 'pricing_compare_rows', '' );
if ( $compare_raw ) {
	$parsed = nutritionist_theme_parse_compare_rows( $compare_raw );
	if ( $parsed ) {
		$compare_rows = $parsed;
	}
}

$faq_defaults = array(
	array(
		'q' => __( 'What is personalized nutrition coaching?', 'nutritionist_theme' ),
		'a' => __( 'Personalized nutrition coaching involves creating a customized nutrition plan based on your unique goals, preferences, and dietary requirements. Our team of experts will work closely with you to develop a plan that fits your lifestyle and helps you achieve optimal health and wellness.', 'nutritionist_theme' ),
	),
	array(
		'q' => __( 'How can nutrition coaching help me lose weight?', 'nutritionist_theme' ),
		'a' => __( 'Nutrition coaching helps you lose weight by building sustainable eating habits, creating calorie and nutrient balance tailored to your body, and providing accountability through regular check-ins and progress tracking.', 'nutritionist_theme' ),
	),
	array(
		'q' => __( 'Can I still enjoy my favorite foods while on a nutrition plan?', 'nutritionist_theme' ),
		'a' => __( 'Yes. We focus on balance rather than restriction, so your plan can include favorite foods in moderation while still supporting your health and wellness goals.', 'nutritionist_theme' ),
	),
	array(
		'q' => __( 'How often will I have contact with my nutritionist?', 'nutritionist_theme' ),
		'a' => __( 'Contact frequency depends on your plan. You can expect email support on all plans, with video and phone consultations available on higher tiers for more frequent guidance.', 'nutritionist_theme' ),
	),
	array(
		'q' => __( 'How long will it take to see results?', 'nutritionist_theme' ),
		'a' => __( 'Results vary by individual goals and consistency. Many clients notice improvements in energy and habits within a few weeks, with more measurable progress building over several months.', 'nutritionist_theme' ),
	),
	array(
		'q' => __( 'Are the meal plans and recipes provided suitable for vegetarians or vegans?', 'nutritionist_theme' ),
		'a' => __( 'Absolutely. We tailor meal plans and recipes to your dietary preferences, including vegetarian, vegan, and other specialized eating styles.', 'nutritionist_theme' ),
	),
);

$faqs = nutritionist_theme_collect_groups(
	'pricing_faq',
	6,
	static function ( $group ) {
		$q = isset( $group['question'] ) ? trim( (string) $group['question'] ) : '';
		if ( '' === $q ) {
			return null;
		}
		return array(
			'q' => $q,
			'a' => isset( $group['answer'] ) ? (string) $group['answer'] : '',
		);
	},
	$faq_defaults
);

$hero_title = nutritionist_theme_get_field( 'pricing_hero_title', __( 'Our Pricing', 'nutritionist_theme' ) );
$hero_text  = nutritionist_theme_get_field(
	'pricing_hero_text',
	__( 'At Nutritionist, we offer flexible pricing options to accommodate your unique requirements and budget. Our goal is to provide you with exceptional personalized nutrition coaching that is accessible and tailored to your needs. Choose from our three plans below and take the first step towards a healthier lifestyle.', 'nutritionist_theme' )
);
$faq_title  = nutritionist_theme_get_field( 'pricing_faq_title', __( 'FAQ', 'nutritionist_theme' ) );
$faq_intro  = nutritionist_theme_get_field(
	'pricing_faq_intro',
	__( 'We address commonly asked questions and provide comprehensive answers to help you navigate your way through your nutrition and wellness journey.', 'nutritionist_theme' )
);
$ask_title  = nutritionist_theme_get_field( 'pricing_ask_title', __( 'Ask your question', 'nutritionist_theme' ) );
$ask_text   = nutritionist_theme_get_field( 'pricing_ask_text', __( 'Feel free to Ask questions on anytime', 'nutritionist_theme' ) );
$ask_label  = nutritionist_theme_get_field( 'pricing_ask_label', __( 'Ask A Question', 'nutritionist_theme' ) );
$ask_url    = nutritionist_theme_get_field( 'pricing_ask_url', home_url( '/contact/' ) );

$badge_path = get_template_directory() . '/assets/images/pricing/pricing-badge.png';
$badge_ver  = file_exists( $badge_path ) ? (string) filemtime( $badge_path ) : _S_VERSION;
?>

	<main id="primary" class="site-main site-main--pricing">

		<section class="pricing-hero" id="pricing-hero" data-hero-enter>
			<div class="container">
				<div class="pricing-hero__panel" data-reveal>
					<div class="pricing-hero__dots" aria-hidden="true"></div>
					<img
						class="pricing-hero__badge"
						src="<?php echo esc_url( nutritionist_theme_image_url( 'pricing/pricing-badge.png' ) . '?v=' . rawurlencode( $badge_ver ) ); ?>"
						alt=""
						width="80"
						height="80"
					>
					<h1 class="pricing-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
					<p class="pricing-hero__text"><?php echo esc_html( $hero_text ); ?></p>
				</div>
			</div>
		</section>

		<section class="section section--pricing-page" id="pricing-plans">
			<div class="container">
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

				<div class="pricing-page-grid" data-reveal-stagger>
					<?php foreach ( $plans as $plan ) : ?>
						<article class="pricing-page-card" data-reveal data-monthly-price="<?php echo esc_attr( (string) $plan['price'] ); ?>">
							<header class="pricing-page-card__header">
								<h2 class="pricing-page-card__name"><?php echo esc_html( $plan['name'] ); ?></h2>
								<p class="pricing-page-card__discount"><?php esc_html_e( 'Up to 50% off on Yearly Plan', 'nutritionist_theme' ); ?></p>
							</header>

							<ul class="pricing-page-card__features">
								<?php foreach ( $plan['features'] as $feature ) : ?>
									<li><?php echo esc_html( $feature ); ?></li>
								<?php endforeach; ?>
							</ul>

							<?php if ( ! empty( $plan['note'] ) ) : ?>
								<p class="pricing-page-card__note"><?php echo esc_html( $plan['note'] ); ?></p>
							<?php endif; ?>

							<div class="pricing-page-card__footer">
								<p class="pricing-page-card__price">
									<span class="pricing-page-card__amount" data-price-amount>$<?php echo esc_html( (string) $plan['price'] ); ?></span>
									<span class="pricing-page-card__period" data-price-period><?php esc_html_e( '/month', 'nutritionist_theme' ); ?></span>
								</p>

								<a
									class="btn btn--primary pricing-page-card__cta"
									href="<?php echo esc_url( add_query_arg( array( 'plan' => $plan['name'], 'billing' => 'monthly' ), home_url( '/contact/' ) ) ); ?>"
									data-plan-cta
									data-plan-name="<?php echo esc_attr( $plan['name'] ); ?>"
								>
									<?php esc_html_e( 'Choose Plan', 'nutritionist_theme' ); ?>
								</a>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="section section--pricing-compare" id="pricing-compare">
			<div class="container">
				<div class="price-compare" data-reveal>
					<div class="price-compare__scroll">
						<table class="price-compare__table">
							<thead>
								<tr>
									<?php foreach ( $compare_headers as $header ) : ?>
										<th scope="col">
											<span class="price-compare__head"><?php echo esc_html( $header ); ?></span>
										</th>
									<?php endforeach; ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $compare_rows as $row ) : ?>
									<tr>
										<th scope="row"><?php echo esc_html( $row[0] ); ?></th>
										<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
											<td>
												<?php if ( ! empty( $row[ $i ] ) ) : ?>
													<span class="price-compare__icon price-compare__icon--yes" aria-label="<?php esc_attr_e( 'Included', 'nutritionist_theme' ); ?>">
														<i class="fa-solid fa-check" aria-hidden="true"></i>
													</span>
												<?php else : ?>
													<span class="price-compare__icon price-compare__icon--no" aria-label="<?php esc_attr_e( 'Not included', 'nutritionist_theme' ); ?>">
														<i class="fa-solid fa-xmark" aria-hidden="true"></i>
													</span>
												<?php endif; ?>
											</td>
										<?php endfor; ?>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>

		<section class="section section--pricing-faq" id="pricing-faq">
			<div class="container">
				<header class="section__header pricing-faq__header">
					<h2 class="section__title"><?php echo esc_html( $faq_title ); ?></h2>
					<p class="section__intro"><?php echo esc_html( $faq_intro ); ?></p>
				</header>

				<div class="pricing-faq" data-reveal>
					<div class="pricing-faq__list" data-pricing-faq>
						<?php foreach ( $faqs as $index => $faq ) : ?>
							<details class="pricing-faq__item" <?php echo 0 === $index ? 'open' : ''; ?>>
								<summary class="pricing-faq__question">
									<span><?php echo esc_html( $faq['q'] ); ?></span>
									<span class="pricing-faq__toggle" aria-hidden="true">
										<i class="fa-solid fa-plus pricing-faq__icon-plus"></i>
										<i class="fa-solid fa-xmark pricing-faq__icon-close"></i>
									</span>
								</summary>
								<div class="pricing-faq__answer">
									<p><?php echo esc_html( $faq['a'] ); ?></p>
								</div>
							</details>
						<?php endforeach; ?>
					</div>

					<aside class="pricing-faq__ask">
						<img
							class="pricing-faq__mark"
							src="<?php echo esc_url( nutritionist_theme_image_url( 'pricing/faq-mark.png' ) ); ?>"
							alt=""
							width="64"
							height="64"
						>
						<h3 class="pricing-faq__ask-title"><?php echo esc_html( $ask_title ); ?></h3>
						<p class="pricing-faq__ask-text"><?php echo esc_html( $ask_text ); ?></p>
						<a class="btn btn--primary pricing-faq__ask-btn" href="<?php echo esc_url( $ask_url ); ?>">
							<?php echo esc_html( $ask_label ); ?>
						</a>
					</aside>
				</div>
			</div>
		</section>

	</main><!-- #main -->

<?php
get_footer();
