<?php
/**
 * Template Name: Process
 *
 * @package nutritionist_theme
 */

get_header();

$step_defaults = array(
	array(
		'icon'  => 'fa-flag',
		'title' => __( 'Initial Consultation', 'nutritionist_theme' ),
		'text'  => __( 'We start by scheduling an initial consultation, either in person or through a convenient online meeting. During this session, we will discuss your health history, lifestyle, goals, and any specific dietary requirements.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-basket-shopping',
		'title' => __( 'Assessing Your Needs', 'nutritionist_theme' ),
		'text'  => __( 'Our team of experienced nutritionists and dietitians will conduct a thorough assessment of your nutritional needs and create a personalized plan tailored to your unique requirements.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-clipboard-list',
		'title' => __( 'Personalized Nutrition Plan', 'nutritionist_theme' ),
		'text'  => __( 'Based on the information gathered, we will develop a personalized nutrition plan that takes into account your dietary preferences, lifestyle, and health goals. This plan will provide you with clear guidelines on what to eat, portion sizes, and meal timing.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-utensils',
		'title' => __( 'Meal Planning and Recipes', 'nutritionist_theme' ),
		'text'  => __( 'To make your journey easier, we will provide you with a variety of delicious and nutritious meal options, along with recipes that align with your personalized nutrition plan.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-headphones',
		'title' => __( 'Ongoing Support', 'nutritionist_theme' ),
		'text'  => __( 'Throughout your journey, our team of nutrition experts will be there to provide ongoing support, answer your questions, and offer guidance. We believe in the power of continuous encouragement to help you stay motivated and achieve long-term success.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-shield-halved',
		'title' => __( 'Progress Tracking', 'nutritionist_theme' ),
		'text'  => __( 'We encourage you to track your progress using our user-friendly mobile app or website tools. You can log your meals, monitor your weight, and track your physical activity, allowing you to have a clear picture of your progress and make any necessary adjustments.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-thumbtack',
		'title' => __( 'Regular Check-ins', 'nutritionist_theme' ),
		'text'  => __( 'We will schedule regular check-ins to review your progress, address any concerns, and make any necessary adjustments to your nutrition plan. Our goal is to ensure that you are consistently moving towards your desired outcomes.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-graduation-cap',
		'title' => __( 'Education and Resources', 'nutritionist_theme' ),
		'text'  => __( 'Along the way, we will provide you with educational resources, such as articles, guides, and videos, to enhance your understanding of nutrition and empower you to make informed choices for a healthier lifestyle.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-weight-scale',
		'title' => __( 'Fine-Tuning and Adjustments', 'nutritionist_theme' ),
		'text'  => __( 'As your journey progresses and your goals evolve, we will fine-tune and make adjustments to your nutrition plan to ensure that it continues to align with your changing needs.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-mug-hot',
		'title' => __( 'Sustainable Lifestyle Habits', 'nutritionist_theme' ),
		'text'  => __( 'Our ultimate goal is to help you develop sustainable lifestyle habits that will support your long-term health and wellness. We will equip you with the knowledge and skills to maintain your progress even after you\'ve completed the program.', 'nutritionist_theme' ),
	),
);

$steps = nutritionist_theme_collect_groups(
	'process_step',
	10,
	static function ( $group ) {
		$title = isset( $group['title'] ) ? trim( (string) $group['title'] ) : '';
		if ( '' === $title ) {
			return null;
		}
		$icon = isset( $group['icon'] ) ? trim( (string) $group['icon'] ) : 'fa-flag';
		if ( $icon && 0 !== strpos( $icon, 'fa-' ) ) {
			$icon = 'fa-' . ltrim( $icon, '-' );
		}
		return array(
			'icon'  => $icon,
			'title' => $title,
			'text'  => isset( $group['text'] ) ? (string) $group['text'] : '',
		);
	},
	$step_defaults
);

$hero_title   = nutritionist_theme_get_field( 'process_hero_title', __( 'Your Journey to Health and Wellness', 'nutritionist_theme' ) );
$hero_text    = nutritionist_theme_get_field(
	'process_hero_text',
	__( 'At Nutritionist, we believe in providing a personalized and comprehensive approach to help you achieve your health and wellness goals. Our “How It Works” process is designed to guide you through each step of your journey — ensuring that you receive the support, knowledge, and tools you need to succeed.', 'nutritionist_theme' )
);
$steps_title  = nutritionist_theme_get_field( 'process_steps_title', __( 'How It Works', 'nutritionist_theme' ) );
$steps_intro  = nutritionist_theme_get_field(
	'process_steps_intro',
	__( 'We provide a step-by-step guide on how to get started on your journey towards better health and nutrition. We are here to simplify the process and make it easy for you to navigate our platform and access the resources you need to achieve your goals. Here\'s how it works.', 'nutritionist_theme' )
);
$cta_title    = nutritionist_theme_get_field(
	'process_cta_title',
	__( 'Are you ready to embark on a transformative journey towards better health and wellness?', 'nutritionist_theme' )
);
$cta_text     = nutritionist_theme_get_field(
	'process_cta_text',
	__( 'Join us at Nutritionist and let us guide you on the path to a healthier and happier you.', 'nutritionist_theme' )
);
$cta_label    = nutritionist_theme_get_field( 'process_cta_label', __( 'Join Us Now', 'nutritionist_theme' ) );
$cta_url      = nutritionist_theme_get_field( 'process_cta_url', home_url( '/contact/' ) );
$badge_path   = get_template_directory() . '/assets/images/process/process-badge.png';
$badge_ver    = file_exists( $badge_path ) ? (string) filemtime( $badge_path ) : _S_VERSION;
?>

	<main id="primary" class="site-main site-main--process">

		<section class="process-hero" id="process-hero" data-hero-enter>
			<div class="container">
				<div class="process-hero__panel" data-reveal>
					<img
						class="process-hero__badge"
						src="<?php echo esc_url( nutritionist_theme_image_url( 'process/process-badge.png' ) . '?v=' . rawurlencode( $badge_ver ) ); ?>"
						alt=""
						width="80"
						height="80"
					>
					<h1 class="process-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
					<p class="process-hero__text"><?php echo esc_html( $hero_text ); ?></p>
				</div>
			</div>
		</section>

		<section class="section section--process" id="how-it-works">
			<div class="container">
				<div class="section__header process-section__header">
					<h2 class="section__title"><?php echo esc_html( $steps_title ); ?></h2>
					<p class="section__intro"><?php echo esc_html( $steps_intro ); ?></p>
				</div>

				<div class="process-grid" data-reveal-stagger>
					<?php foreach ( $steps as $index => $step ) : ?>
						<article class="process-card" data-reveal>
							<span class="process-card__number" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
							<div class="process-card__body">
								<div class="process-card__head">
									<span class="process-card__icon" aria-hidden="true"><i class="fa-solid <?php echo esc_attr( $step['icon'] ); ?>"></i></span>
									<h3 class="process-card__title"><?php echo esc_html( $step['title'] ); ?></h3>
								</div>
								<p class="process-card__text"><?php echo esc_html( $step['text'] ); ?></p>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="section section--process-cta" id="process-cta">
			<div class="container">
				<div class="process-cta is-reveal--scale" data-reveal>
					<img class="process-cta__decor process-cta__decor--left" src="<?php echo esc_url( nutritionist_theme_image_url( 'process/cta-abstract-1.png' ) ); ?>" alt="" width="180" height="120" aria-hidden="true">
					<img class="process-cta__decor process-cta__decor--right" src="<?php echo esc_url( nutritionist_theme_image_url( 'process/cta-abstract-2.png' ) ); ?>" alt="" width="120" height="120" aria-hidden="true">
					<div class="process-cta__copy">
						<h2 class="process-cta__title"><?php echo esc_html( $cta_title ); ?></h2>
						<p class="process-cta__text"><?php echo esc_html( $cta_text ); ?></p>
					</div>
					<a class="btn btn--primary process-cta__btn" href="<?php echo esc_url( $cta_url ); ?>">
						<?php echo esc_html( $cta_label ); ?>
					</a>
				</div>
			</div>
		</section>

	</main>

<?php
get_footer();
