<?php
/**
 * Template Name: About
 *
 * @package nutritionist_theme
 */

get_header();

$story_defaults = array(
	array(
		'img'   => 'about/story-01.png',
		'title' => __( 'Inspiring Transformations Story', 'nutritionist_theme' ),
		'text'  => __( 'Nutritionist continues to empower individuals to transform their lives through personalized nutrition coaching. With an expanding client base and a growing team of experts, we remain committed to our goal of helping people lose weight, improve their health, and lead happier, more fulfilling lives. Our journey of inspiring transformations continues, one client at a time.', 'nutritionist_theme' ),
		'date'  => 'July 1, 2025',
	),
	array(
		'img'   => 'about/story-02.png',
		'title' => __( 'Recognition and Accolades Story', 'nutritionist_theme' ),
		'text'  => __( 'Nutritionist received industry recognition for its excellence in personalized nutrition coaching. Our innovative approach and dedication to client success earned us accolades and solidified our position as a leading provider in the field.', 'nutritionist_theme' ),
		'date'  => 'March 10, 2023',
	),
	array(
		'img'   => 'about/story-03.png',
		'title' => __( 'Continued Growth Story', 'nutritionist_theme' ),
		'text'  => __( 'Nutritionist celebrated serving over 5,000 clients, a testament to our commitment to helping individuals achieve their health and weight loss goals. This milestone highlighted the positive impact we have made on the lives of thousands of people.', 'nutritionist_theme' ),
		'date'  => 'November 2, 2021',
	),
	array(
		'img'   => 'about/story-04.png',
		'title' => __( 'Collaborating for Success Story', 'nutritionist_theme' ),
		'text'  => __( 'Nutritionist established partnerships with renowned health professionals, including nutritionists, dietitians, and wellness experts. These collaborations allowed us to incorporate diverse perspectives and expertise, ensuring the highest level of guidance for our clients.', 'nutritionist_theme' ),
		'date'  => 'July 15, 2019',
	),
	array(
		'img'   => 'about/story-05.png',
		'title' => __( 'Enhanced Support Story', 'nutritionist_theme' ),
		'text'  => __( 'In response to the growing demand for personalized nutrition coaching, Nutritionist expanded its team of qualified nutritionists and dietitians. This milestone enabled us to provide even more individualized care and support to our clients.', 'nutritionist_theme' ),
		'date'  => 'April 1, 2018',
	),
	array(
		'img'   => 'about/story-06.png',
		'title' => __( 'Innovating for Clients Story', 'nutritionist_theme' ),
		'text'  => __( 'Nutritionist introduced a mobile app, revolutionizing the way clients engage with their personalized nutrition plans. The app allowed for easy tracking of progress, access to resources, and seamless communication with their dedicated nutrition coaches.', 'nutritionist_theme' ),
		'date'  => 'January 20, 2017',
	),
	array(
		'img'   => 'about/story-07.png',
		'title' => __( 'Celebrating Success Stories', 'nutritionist_theme' ),
		'text'  => __( 'Nutritionist celebrated its 500th client success story. These stories showcased the positive impact of personalized nutrition coaching on individuals\' lives, further motivating our team to continue providing exceptional services.', 'nutritionist_theme' ),
		'date'  => 'September 5, 2015',
	),
	array(
		'img'   => 'about/story-08.png',
		'title' => __( 'Expanding Reach Story', 'nutritionist_theme' ),
		'text'  => __( 'Nutritionist expanded its services by launching an online platform, allowing individuals from all over the world to access personalized nutrition plans and expert guidance. This milestone brought convenience and accessibility to our growing client base.', 'nutritionist_theme' ),
		'date'  => 'June 10, 2014',
	),
	array(
		'img'   => 'about/story-09.png',
		'title' => __( 'Research and Expertise Story', 'nutritionist_theme' ),
		'text'  => __( 'After extensive research and collaborating with nutrition experts, Sarah Mitchell and her team developed a comprehensive program rooted in scientific knowledge and evidence-based strategies. This milestone marked the establishment of Nutritionist as a trusted source of personalized nutrition coaching.', 'nutritionist_theme' ),
		'date'  => 'March 15, 2012',
	),
	array(
		'img'   => 'about/story-10.png',
		'title' => __( 'The Inception Story', 'nutritionist_theme' ),
		'text'  => __( 'On this day, Nutritionist was born with the vision of helping individuals achieve their weight loss and health goals through personalized nutrition coaching. The founder, Sarah Mitchell, recognized the need for a sustainable and effective approach to healthy living, and thus began the journey of Nutritionist.', 'nutritionist_theme' ),
		'date'  => 'January 1, 2010',
	),
);

$stories = nutritionist_theme_collect_groups(
	'about_story',
	10,
	static function ( $group, $i ) use ( $story_defaults ) {
		$title = isset( $group['title'] ) ? trim( (string) $group['title'] ) : '';
		if ( '' === $title ) {
			return null;
		}
		$fallback = isset( $story_defaults[ $i - 1 ] ) ? $story_defaults[ $i - 1 ] : $story_defaults[0];
		return array(
			'img'   => ! empty( $group['image'] ) ? $group['image'] : $fallback['img'],
			'title' => $title,
			'text'  => isset( $group['text'] ) ? (string) $group['text'] : '',
			'date'  => ! empty( $group['date'] ) ? $group['date'] : $fallback['date'],
		);
	},
	$story_defaults
);

$achieve_defaults = array(
	array(
		'icon'  => 'fa-seedling',
		'title' => __( '10,000+ Transformations', 'nutritionist_theme' ),
		'text'  => __( 'Our personalized nutrition plans have helped thousands of individuals reach their weight loss goals and maintain a healthy lifestyle.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-graduation-cap',
		'title' => __( 'Recognition for Excellence', 'nutritionist_theme' ),
		'text'  => __( 'Nutritionist has been recognized as a leading provider of personalized nutrition coaching, receiving accolades for our innovative approach and commitment to client success.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-utensils',
		'title' => __( 'Positive Client Reviews', 'nutritionist_theme' ),
		'text'  => __( 'We have received numerous testimonials from satisfied clients who have experienced significant improvements in their health, weight, and overall well-being through our coaching program.', 'nutritionist_theme' ),
	),
	array(
		'icon'  => 'fa-clipboard-list',
		'title' => __( 'Collaborate With Top Health Experts.', 'nutritionist_theme' ),
		'text'  => __( 'Nutritionist has established partnerships with respected nutritionists, dietitians, and health experts to ensure that our clients receive the highest quality guidance and support.', 'nutritionist_theme' ),
	),
);

$achievements = nutritionist_theme_collect_groups(
	'about_achieve',
	4,
	static function ( $group ) {
		$title = isset( $group['title'] ) ? trim( (string) $group['title'] ) : '';
		if ( '' === $title ) {
			return null;
		}
		$icon = isset( $group['icon'] ) ? trim( (string) $group['icon'] ) : 'fa-seedling';
		if ( $icon && 0 !== strpos( $icon, 'fa-' ) ) {
			$icon = 'fa-' . ltrim( $icon, '-' );
		}
		return array(
			'icon'  => $icon,
			'title' => $title,
			'text'  => isset( $group['text'] ) ? (string) $group['text'] : '',
		);
	},
	$achieve_defaults
);

$hero_title = nutritionist_theme_get_field( 'about_hero_title', __( 'Welcome to Nutritionist', 'nutritionist_theme' ) );
$hero_p1    = nutritionist_theme_get_field(
	'about_hero_p1',
	__( 'Welcome to Nutritionist, your premier destination for personalized nutrition coaching. We are passionately committed to helping you achieve your health and wellness goals through tailored plans that work for real life.', 'nutritionist_theme' )
);
$hero_p2    = nutritionist_theme_get_field(
	'about_hero_p2',
	__( 'Our certified nutritionists bring years of experience — supporting weight loss and health goals through science-backed guidance, ongoing encouragement, and a community that celebrates every step of your journey.', 'nutritionist_theme' )
);
$hero_grid = nutritionist_theme_get_field( 'about_hero_grid', null );
$grid_src  = nutritionist_theme_media_src( $hero_grid, 'about/hero-grid.png' );

$story_title = nutritionist_theme_get_field( 'about_story_title', __( 'Our Story', 'nutritionist_theme' ) );
$story_intro = nutritionist_theme_get_field(
	'about_story_intro',
	__( 'Welcome to Nutritionist, your premier destination for personalized nutrition coaching. Our journey began with a simple yet powerful vision — to help individuals unlock their fullest potential through the science of nutrition.', 'nutritionist_theme' )
);

$achieve_title = nutritionist_theme_get_field( 'about_achieve_title', __( 'Company Achievements', 'nutritionist_theme' ) );
$achieve_intro = nutritionist_theme_get_field(
	'about_achieve_intro',
	__( 'At Nutritionist, we take pride in our accomplishments and the positive impact we have made on the lives of our clients. Here are some of our notable achievements.', 'nutritionist_theme' )
);

$cta_title = nutritionist_theme_get_field( 'about_cta_title', __( 'We Are Proud of Our Achievements', 'nutritionist_theme' ) );
$cta_text  = nutritionist_theme_get_field(
	'about_cta_text',
	__( 'But our ultimate satisfaction comes from seeing our clients achieve their goals and live healthier, happier lives. Join Nutritionist today and embark on your own transformative journey towards optimal health and well-being.', 'nutritionist_theme' )
);
$cta_label = nutritionist_theme_get_field( 'about_cta_label', __( 'Book a Demo', 'nutritionist_theme' ) );
$cta_url   = nutritionist_theme_get_field( 'about_cta_url', home_url( '/contact/' ) );
?>

	<main id="primary" class="site-main site-main--about">

		<section class="about-hero" id="about-hero" data-hero-enter>
			<div class="about-hero__grid">
				<img
					src="<?php echo esc_url( $grid_src ); ?>"
					alt="<?php esc_attr_e( 'Nutritionist Soft UI brand mosaic', 'nutritionist_theme' ); ?>"
					width="1597"
					height="520"
				>
			</div>
			<div class="container">
				<div class="about-hero__intro">
					<h1 class="about-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
					<div class="about-hero__text">
						<p><?php echo esc_html( $hero_p1 ); ?></p>
						<p><?php echo esc_html( $hero_p2 ); ?></p>
					</div>
				</div>
			</div>
		</section>

		<section class="section section--story" id="our-story">
			<div class="container">
				<div class="section__header">
					<h2 class="section__title"><?php echo esc_html( $story_title ); ?></h2>
					<p class="section__intro"><?php echo esc_html( $story_intro ); ?></p>
				</div>

				<div class="story-timeline" data-reveal-stagger>
					<?php foreach ( $stories as $story ) : ?>
						<article class="story-row" data-reveal>
							<div class="story-row__media">
								<img
									src="<?php echo esc_url( nutritionist_theme_media_src( $story['img'], is_string( $story['img'] ) ? $story['img'] : 'about/story-01.png' ) ); ?>"
									alt=""
									width="789"
									height="530"
									loading="lazy"
								>
							</div>
							<div class="story-row__panel">
								<div class="story-row__copy">
									<h3 class="story-row__title"><?php echo esc_html( $story['title'] ); ?></h3>
									<p class="story-row__text"><?php echo esc_html( $story['text'] ); ?></p>
								</div>
								<p class="story-row__date"><?php echo esc_html( $story['date'] ); ?></p>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="section section--achievements" id="achievements">
			<div class="container">
				<div class="section__header">
					<h2 class="section__title"><?php echo esc_html( $achieve_title ); ?></h2>
					<p class="section__intro"><?php echo esc_html( $achieve_intro ); ?></p>
				</div>

				<div class="achieve-grid" data-reveal-stagger>
					<?php foreach ( $achievements as $card ) : ?>
						<article class="achieve-card" data-reveal>
							<div class="achieve-card__head">
								<span class="achieve-card__icon" aria-hidden="true"><i class="fa-solid <?php echo esc_attr( $card['icon'] ); ?>"></i></span>
								<h3 class="achieve-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
							</div>
							<p class="achieve-card__text"><?php echo esc_html( $card['text'] ); ?></p>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="section section--about-cta" id="about-cta">
			<div class="container">
				<div class="about-cta is-reveal--scale" data-reveal>
					<img class="about-cta__decor about-cta__decor--left" src="<?php echo esc_url( nutritionist_theme_image_url( 'about/cta-abstract-1.png' ) ); ?>" alt="" width="220" height="140" aria-hidden="true">
					<img class="about-cta__decor about-cta__decor--right" src="<?php echo esc_url( nutritionist_theme_image_url( 'about/cta-abstract-2.png' ) ); ?>" alt="" width="140" height="140" aria-hidden="true">
					<div class="about-cta__copy">
						<h2 class="about-cta__title"><?php echo esc_html( $cta_title ); ?></h2>
						<p class="about-cta__text"><?php echo esc_html( $cta_text ); ?></p>
					</div>
					<a class="btn btn--primary about-cta__btn" href="<?php echo esc_url( $cta_url ); ?>">
						<?php echo esc_html( $cta_label ); ?>
					</a>
				</div>
			</div>
		</section>

	</main>

<?php
get_footer();
