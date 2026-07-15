<?php
/**
 * Template Name: Blog
 *
 * @package nutritionist_theme
 */

get_header();

$category_defaults = array(
	'all'     => __( 'All', 'nutritionist_theme' ),
	'weight'  => __( 'Weight Loss Tips', 'nutritionist_theme' ),
	'eating'  => __( 'Healthy Eating', 'nutritionist_theme' ),
	'fitness' => __( 'Fitness and Exercise', 'nutritionist_theme' ),
	'mindset' => __( 'Mindset and Motivation', 'nutritionist_theme' ),
	'recipes' => __( 'Recipes and Meal Planning', 'nutritionist_theme' ),
);

$categories = $category_defaults;
$cat_raw    = nutritionist_theme_get_field( 'blog_filter_categories', '' );
$all_label  = nutritionist_theme_get_field( 'blog_filter_all', __( 'All', 'nutritionist_theme' ) );
if ( $cat_raw ) {
	$custom = array( 'all' => $all_label );
	foreach ( nutritionist_theme_lines_to_array( $cat_raw ) as $line ) {
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		if ( 2 === count( $parts ) && '' !== $parts[1] ) {
			$custom[ $parts[1] ] = $parts[0];
		} elseif ( 1 === count( $parts ) && '' !== $parts[0] ) {
			$slug             = sanitize_title( $parts[0] );
			$custom[ $slug ] = $parts[0];
		}
	}
	if ( count( $custom ) > 1 ) {
		$categories = $custom;
	}
} else {
	$categories['all'] = $all_label;
}

$post_defaults = array(
	array( 'cat' => 'weight', 'title' => __( '10 Effective Strategies for Sustainable Weight Loss', 'nutritionist_theme' ), 'text' => __( 'Discover a range of effective strategies that can help you achieve sustainable weight loss and maintain a healthy lifestyle in the long run.', 'nutritionist_theme' ), 'image' => 'blogpage/post-1.png' ),
	array( 'cat' => 'weight', 'title' => __( 'The Role of Portion Control in Weight Management', 'nutritionist_theme' ), 'text' => __( 'Learn how practicing portion control can be a powerful tool in managing your weight effectively and sustainably.', 'nutritionist_theme' ), 'image' => 'blogpage/post-2.png' ),
	array( 'cat' => 'weight', 'title' => __( 'Understanding Emotional Eating and How to Overcome It', 'nutritionist_theme' ), 'text' => __( 'Explore the connection between emotions and eating habits, and discover strategies to overcome emotional eating.', 'nutritionist_theme' ), 'image' => 'blogpage/post-3.png' ),
	array( 'cat' => 'weight', 'title' => __( 'How to Stay Motivated on Your Weight Loss Journey', 'nutritionist_theme' ), 'text' => __( 'Find valuable tips and strategies to stay motivated and overcome challenges during your weight loss journey.', 'nutritionist_theme' ), 'image' => 'blogpage/post-4.png' ),
	array( 'cat' => 'eating', 'title' => __( 'The Benefits of a Plant-Based Diet for Overall Health', 'nutritionist_theme' ), 'text' => __( 'Explore the numerous health benefits of adopting a plant-based diet, from improved heart health to better digestion.', 'nutritionist_theme' ), 'image' => 'blogpage/post-5.png' ),
	array( 'cat' => 'eating', 'title' => __( 'Understanding Macronutrients: Carbohydrates, Proteins, and Fats', 'nutritionist_theme' ), 'text' => __( 'Get a comprehensive understanding of macronutrients and their roles in fueling your body for optimal health.', 'nutritionist_theme' ), 'image' => 'blogpage/post-6.png' ),
	array( 'cat' => 'fitness', 'title' => __( 'Cardio vs. Strength Training: Which Is Better for Weight Loss?', 'nutritionist_theme' ), 'text' => __( 'Explore the benefits of both cardio and strength training for weight loss and determine which approach is best for you.', 'nutritionist_theme' ), 'image' => 'blogpage/post-7.png' ),
	array( 'cat' => 'fitness', 'title' => __( 'Building a Home Workout Routine: Tips and Best Practices', 'nutritionist_theme' ), 'text' => __( 'Learn how to create an effective home workout routine that fits your lifestyle, schedule, and fitness goals.', 'nutritionist_theme' ), 'image' => 'blogpage/post-8.png' ),
	array( 'cat' => 'mindset', 'title' => __( 'Developing a Positive Body Image and Self-Confidence', 'nutritionist_theme' ), 'text' => __( 'Explore strategies to cultivate a positive body image and improve your overall self-confidence along your wellness journey.', 'nutritionist_theme' ), 'image' => 'blogpage/post-9.png' ),
	array( 'cat' => 'mindset', 'title' => __( 'Overcoming Self-Sabotage in Your Weight Loss Journey', 'nutritionist_theme' ), 'text' => __( 'Identify self-sabotaging behaviors and learn effective strategies that help you stay consistent with your goals.', 'nutritionist_theme' ), 'image' => 'blogpage/post-10.png' ),
	array( 'cat' => 'recipes', 'title' => __( 'Healthy and Flavorful Lunch Ideas for a Busy Lifestyle', 'nutritionist_theme' ), 'text' => __( 'Discover a variety of nutritious and delicious lunch ideas that are quick to prepare for busy days.', 'nutritionist_theme' ), 'image' => 'blogpage/post-11.png' ),
	array( 'cat' => 'recipes', 'title' => __( 'Satisfying and Nutritious Dinner Recipes for Weight Loss', 'nutritionist_theme' ), 'text' => __( 'Find a collection of flavorful dinner recipes that help you stay on track with your weight loss goals.', 'nutritionist_theme' ), 'image' => 'blogpage/post-12.png' ),
);

$wp_posts = nutritionist_theme_get_wp_blog_cards( 0 );
if ( $wp_posts ) {
	$posts = $wp_posts;
} else {
	$posts = nutritionist_theme_collect_groups(
		'blog_post',
		12,
		static function ( $group, $i ) use ( $post_defaults, $categories ) {
			$title = isset( $group['title'] ) ? trim( (string) $group['title'] ) : '';
			if ( '' === $title ) {
				return null;
			}
			$fallback = isset( $post_defaults[ $i - 1 ] ) ? $post_defaults[ $i - 1 ] : $post_defaults[0];
			$cat      = ! empty( $group['category'] ) ? sanitize_title( $group['category'] ) : $fallback['cat'];
			$cat_label = ! empty( $group['category_label'] )
				? $group['category_label']
				: ( isset( $categories[ $cat ] ) ? $categories[ $cat ] : $cat );
			return array(
				'cat'   => $cat,
				'title' => $title,
				'text'  => isset( $group['excerpt'] ) ? (string) $group['excerpt'] : '',
				'image' => ! empty( $group['image'] ) ? $group['image'] : $fallback['image'],
				'label' => $cat_label,
				'link'  => home_url( '/blog/' ),
				'alt'   => $title,
			);
		},
		array_map(
			static function ( $p ) use ( $categories ) {
				$p['label'] = isset( $categories[ $p['cat'] ] ) ? $categories[ $p['cat'] ] : $p['cat'];
				$p['link']  = home_url( '/blog/' );
				$p['alt']   = $p['title'];
				return $p;
			},
			$post_defaults
		)
	);
}

$hero_title = nutritionist_theme_get_field( 'blog_hero_title', __( 'Our Blogs', 'nutritionist_theme' ) );
$hero_text  = nutritionist_theme_get_field(
	'blog_hero_text',
	__( 'Our blog is a valuable resource with insightful articles, tips, and expert advice to help you achieve your health and wellness goals. Stay informed, inspired, and empowered as you uncover the latest trends in nutrition, sustainable weight loss, and healthier lifestyle choices.', 'nutritionist_theme' )
);

$badge_path = get_template_directory() . '/assets/images/blogpage/blog-badge.png';
$badge_ver  = file_exists( $badge_path ) ? (string) filemtime( $badge_path ) : _S_VERSION;
?>

	<main id="primary" class="site-main site-main--blog">

		<section class="blog-hero" id="blog-hero" data-hero-enter>
			<div class="container">
				<div class="blog-hero__panel" data-reveal>
					<div class="blog-hero__dots" aria-hidden="true"></div>
					<img
						class="blog-hero__badge"
						src="<?php echo esc_url( nutritionist_theme_image_url( 'blogpage/blog-badge.png' ) . '?v=' . rawurlencode( $badge_ver ) ); ?>"
						alt=""
						width="80"
						height="80"
					>
					<h1 class="blog-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
					<p class="blog-hero__text"><?php echo esc_html( $hero_text ); ?></p>
				</div>
			</div>
		</section>

		<section class="blog-filters" aria-label="<?php esc_attr_e( 'Blog categories', 'nutritionist_theme' ); ?>">
			<div class="container">
				<div class="blog-filters__bar" data-blog-filters>
					<?php foreach ( $categories as $slug => $label ) : ?>
						<button
							type="button"
							class="blog-filters__btn<?php echo 'all' === $slug ? ' is-active' : ''; ?>"
							data-filter="<?php echo esc_attr( $slug ); ?>"
							aria-pressed="<?php echo 'all' === $slug ? 'true' : 'false'; ?>"
						>
							<?php echo esc_html( $label ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="section section--blog-grid" id="blog-grid">
			<div class="container">
				<div class="blog-grid" data-blog-grid data-reveal-stagger>
					<?php foreach ( $posts as $post_item ) : ?>
						<?php
						$card_link  = ! empty( $post_item['link'] ) ? $post_item['link'] : home_url( '/blog/' );
						$card_alt   = ! empty( $post_item['alt'] ) ? $post_item['alt'] : $post_item['title'];
						$card_image = nutritionist_theme_media_src( $post_item['image'], 'blogpage/post-1.png' );
						?>
						<article class="blog-post-card" data-reveal data-category="<?php echo esc_attr( $post_item['cat'] ); ?>">
							<p class="blog-post-card__cat"><?php echo esc_html( $post_item['label'] ); ?></p>
							<img
								class="blog-post-card__image"
								src="<?php echo esc_url( $card_image ); ?>"
								alt="<?php echo esc_attr( $card_alt ); ?>"
								width="640"
								height="360"
								loading="lazy"
							>
							<div class="blog-post-card__body">
								<div class="blog-post-card__copy">
									<h2 class="blog-post-card__title"><?php echo esc_html( $post_item['title'] ); ?></h2>
									<p class="blog-post-card__text"><?php echo esc_html( $post_item['text'] ); ?></p>
								</div>
								<a class="btn btn--primary blog-post-card__cta" href="<?php echo esc_url( $card_link ); ?>">
									<?php esc_html_e( 'Read More', 'nutritionist_theme' ); ?>
								</a>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

	</main><!-- #main -->

<?php
get_footer();
