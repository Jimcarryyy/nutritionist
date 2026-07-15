<?php
/**
 * Template part: Blogs section (home)
 *
 * @package nutritionist_theme
 */

$front_id = nutritionist_theme_get_front_page_id();
$pid      = $front_id ? $front_id : null;

$defaults = array(
	array(
		'category' => __( 'Weight Loss', 'nutritionist_theme' ),
		'title'    => __( 'The Benefits of Hydration for Weight Loss', 'nutritionist_theme' ),
		'excerpt'  => __( 'Discover how staying hydrated can support your weight loss goals and improve overall health.', 'nutritionist_theme' ),
		'author'   => __( 'Emily Johnson', 'nutritionist_theme' ),
		'date'     => __( '23 May 2023', 'nutritionist_theme' ),
		'image'    => 'blog/hydration.png',
		'avatar'   => 'avatars/avatar-1.png',
		'link'     => home_url( '/blog/' ),
	),
	array(
		'category' => __( 'Mindful Eating', 'nutritionist_theme' ),
		'title'    => __( 'Cultivating a Healthy Relationship with Food', 'nutritionist_theme' ),
		'excerpt'  => __( 'Learn how practicing mindful eating can help you develop a healthier relationship with food and improve your overall well-being.', 'nutritionist_theme' ),
		'author'   => __( 'Sarah Thompson', 'nutritionist_theme' ),
		'date'     => __( '23 May 2023', 'nutritionist_theme' ),
		'image'    => 'blog/mindful-eating.png',
		'avatar'   => 'avatars/avatar-2.png',
		'link'     => home_url( '/blog/' ),
	),
	array(
		'category' => __( 'Understanding Macronutrients', 'nutritionist_theme' ),
		'title'    => __( 'Carbohydrates, Proteins, and Fats', 'nutritionist_theme' ),
		'excerpt'  => __( 'Get a comprehensive understanding of macronutrients and their role in your diet for optimal health and weight management.', 'nutritionist_theme' ),
		'author'   => __( 'Mark Wilson', 'nutritionist_theme' ),
		'date'     => __( '23 May 2023', 'nutritionist_theme' ),
		'image'    => 'blog/macronutrients.png',
		'avatar'   => 'avatars/avatar-3.png',
		'link'     => home_url( '/blog/' ),
	),
	array(
		'category' => __( 'Healthy Snacks on the Go', 'nutritionist_theme' ),
		'title'    => __( 'Quick and Nutritious Options', 'nutritionist_theme' ),
		'excerpt'  => __( 'Explore a variety of convenient and healthy snack ideas to keep you fueled throughout the day.', 'nutritionist_theme' ),
		'author'   => __( 'Emily Johnson', 'nutritionist_theme' ),
		'date'     => __( '23 May 2023', 'nutritionist_theme' ),
		'image'    => 'blog/healthy-snacks.png',
		'avatar'   => 'avatars/avatar-4.png',
		'link'     => home_url( '/blog/' ),
	),
);

$wp_home_blogs = nutritionist_theme_get_wp_blog_cards( 4 );
if ( $wp_home_blogs ) {
	$blogs = array();
	foreach ( $wp_home_blogs as $i => $card ) {
		$fallback = isset( $defaults[ $i ] ) ? $defaults[ $i ] : $defaults[0];
		$blogs[]  = array(
			'category' => $card['label'],
			'title'    => $card['title'],
			'excerpt'  => $card['text'],
			'author'   => ! empty( $card['author'] ) ? $card['author'] : $fallback['author'],
			'date'     => ! empty( $card['date'] ) ? $card['date'] : $fallback['date'],
			'image'    => $card['image'],
			'avatar'   => $fallback['avatar'],
			'link'     => $card['link'],
			'alt'      => $card['alt'],
		);
	}
} else {
	$blogs = nutritionist_theme_collect_groups(
		'home_blog',
		4,
		static function ( $group, $i ) use ( $defaults ) {
			$title = isset( $group['title'] ) ? trim( (string) $group['title'] ) : '';
			if ( '' === $title ) {
				return null;
			}
			$fallback = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : $defaults[0];
			return array(
				'category' => ! empty( $group['category'] ) ? $group['category'] : $fallback['category'],
				'title'    => $title,
				'excerpt'  => ! empty( $group['excerpt'] ) ? $group['excerpt'] : '',
				'author'   => ! empty( $group['author'] ) ? $group['author'] : $fallback['author'],
				'date'     => ! empty( $group['date'] ) ? $group['date'] : $fallback['date'],
				'image'    => ! empty( $group['image'] ) ? $group['image'] : $fallback['image'],
				'avatar'   => ! empty( $group['avatar'] ) ? $group['avatar'] : $fallback['avatar'],
				'link'     => ! empty( $group['link'] ) ? $group['link'] : home_url( '/blog/' ),
				'alt'      => $title,
			);
		},
		$defaults,
		$pid
	);
}

$section_title = nutritionist_theme_get_field( 'home_blogs_title', __( 'Our Blogs', 'nutritionist_theme' ), $pid );
$section_intro = nutritionist_theme_get_field(
	'home_blogs_intro',
	__( 'Our blog is a treasure trove of informative and engaging articles written by our team of nutritionists, dietitians, and wellness experts. Here\'s what you can expect from our blog.', 'nutritionist_theme' ),
	$pid
);
?>

<section class="section section--blogs" id="blogs">
	<div class="container">
		<header class="section__header">
			<h2 class="section__title"><?php echo esc_html( $section_title ); ?></h2>
			<p class="section__intro"><?php echo esc_html( $section_intro ); ?></p>
		</header>

		<div class="blogs-grid" data-reveal-stagger>
			<?php foreach ( $blogs as $post_item ) : ?>
				<?php
				$card_alt   = ! empty( $post_item['alt'] ) ? $post_item['alt'] : $post_item['title'];
				$card_image = nutritionist_theme_media_src( $post_item['image'], 'blog/hydration.png' );
				?>
				<article class="blog-card" data-reveal>
					<a class="blog-card__media" href="<?php echo esc_url( $post_item['link'] ); ?>">
						<img
							src="<?php echo esc_url( $card_image ); ?>"
							alt="<?php echo esc_attr( $card_alt ); ?>"
							width="703"
							height="428"
							loading="lazy"
						>
					</a>
					<div class="blog-card__body">
						<span class="blog-card__category"><?php echo esc_html( $post_item['category'] ); ?></span>
						<h3 class="blog-card__title">
							<a href="<?php echo esc_url( $post_item['link'] ); ?>"><?php echo esc_html( $post_item['title'] ); ?></a>
						</h3>
						<p class="blog-card__excerpt"><?php echo esc_html( $post_item['excerpt'] ); ?></p>
						<div class="blog-card__meta">
							<div class="blog-card__author">
								<img
									src="<?php echo esc_url( nutritionist_theme_media_src( $post_item['avatar'], is_string( $post_item['avatar'] ) ? $post_item['avatar'] : 'avatars/avatar-1.png' ) ); ?>"
									alt=""
									width="50"
									height="50"
									loading="lazy"
								>
								<div>
									<span class="blog-card__author-name"><?php echo esc_html( $post_item['author'] ); ?></span>
									<span class="blog-card__date"><?php echo esc_html( $post_item['date'] ); ?> · <?php esc_html_e( '5 min read', 'nutritionist_theme' ); ?></span>
								</div>
							</div>
							<div class="blog-card__actions" aria-hidden="true">
								<span><i class="fa-regular fa-heart"></i></span>
								<span><i class="fa-regular fa-bookmark"></i></span>
							</div>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
