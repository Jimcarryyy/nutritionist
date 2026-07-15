<?php
/**
 * Template part: Features section
 *
 * @package nutritionist_theme
 */

$front_id = nutritionist_theme_get_front_page_id();
$pid      = $front_id ? $front_id : null;

$defaults = array(
	array(
		'icon'  => 'fa-leaf',
		'title' => __( 'Personalized Nutrition Plans', 'nutritionist_theme' ),
		'text'  => __( 'Receive a tailored nutrition plan designed specifically for your body and goals. Our certified nutritionists will consider your unique needs, dietary preferences, and health conditions to create a plan that suits you best.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-graduation-cap',
		'title' => __( 'Guidance from Certified Nutritionists', 'nutritionist_theme' ),
		'text'  => __( 'Our team of experienced and certified nutritionists will provide professional guidance and support throughout your journey. They will answer your questions, address your concerns, and keep you motivated as you work towards your goals.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-utensils',
		'title' => __( 'Food Tracking and Analysis', 'nutritionist_theme' ),
		'text'  => __( 'Effortlessly track your food intake using our user-friendly app. Our nutritionists will analyze your data to provide insights into your eating habits, help you identify areas for improvement, and make personalized recommendations.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-clipboard-list',
		'title' => __( 'Meal Planning and Recipes', 'nutritionist_theme' ),
		'text'  => __( 'Access a vast collection of delicious and healthy recipes tailored to your dietary needs. Our nutritionists will also create personalized meal plans, making it easier for you to stay on track and enjoy nutritious meals.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-person-running',
		'title' => __( 'Lifestyle and Behavior Coaching', 'nutritionist_theme' ),
		'text'  => __( 'Achieving sustainable results requires more than just a diet plan. Our nutritionists will work with you to develop healthy habits, address emotional eating, and provide strategies to overcome obstacles along the way.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-book-open',
		'title' => __( 'Nutritional Education and Workshops', 'nutritionist_theme' ),
		'text'  => __( 'Expand your knowledge of nutrition through informative articles and educational workshops. Our nutritionists will equip you with the knowledge and tools to make informed choices for long-term success.', 'nutritionist_theme' ),
	),
);

$features = nutritionist_theme_collect_groups(
	'home_feature',
	6,
	static function ( $group ) {
		$title = isset( $group['title'] ) ? trim( (string) $group['title'] ) : '';
		if ( '' === $title ) {
			return null;
		}
		$icon = isset( $group['icon'] ) ? trim( (string) $group['icon'] ) : 'fa-leaf';
		if ( 0 !== strpos( $icon, 'fa-' ) ) {
			$icon = 'fa-' . ltrim( $icon, '-' );
		}
		return array(
			'icon'  => $icon,
			'title' => $title,
			'text'  => isset( $group['text'] ) ? (string) $group['text'] : '',
		);
	},
	$defaults,
	$pid
);

$section_title = nutritionist_theme_get_field( 'home_features_title', __( 'Features', 'nutritionist_theme' ), $pid );
$section_intro = nutritionist_theme_get_field(
	'home_features_intro',
	__( 'Welcome to the Feature Section of Nutritionist, your ultimate destination for all things nutrition and wellness.', 'nutritionist_theme' ),
	$pid
);
?>

<section class="section section--features" id="features">
	<div class="container">
		<header class="section__header">
			<h2 class="section__title"><?php echo esc_html( $section_title ); ?></h2>
			<p class="section__intro"><?php echo esc_html( $section_intro ); ?></p>
		</header>

		<div class="features-grid" data-reveal-stagger>
			<?php foreach ( $features as $feature ) : ?>
				<article class="feature-card" data-reveal>
					<span class="feature-card__icon" aria-hidden="true">
						<i class="fa-solid <?php echo esc_attr( $feature['icon'] ); ?>"></i>
					</span>
					<h3 class="feature-card__title"><?php echo esc_html( $feature['title'] ); ?></h3>
					<p class="feature-card__text"><?php echo esc_html( $feature['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
