<?php
/**
 * Template part: Testimonials section
 *
 * @package nutritionist_theme
 */

$front_id = nutritionist_theme_get_front_page_id();
$pid      = $front_id ? $front_id : null;

$defaults = array(
	array(
		'name'   => __( 'Jennifer Anderson', 'nutritionist_theme' ),
		'quote'  => __( 'I can\'t thank Nutritionist enough for their personalized nutrition coaching. It has completely transformed my approach to food and helped me shed those extra pounds. Highly recommended!', 'nutritionist_theme' ),
		'avatar' => 'avatars/avatar-5.png',
	),
	array(
		'name'   => __( 'Robert Johnson', 'nutritionist_theme' ),
		'quote'  => __( 'Nutritionist has been a game-changer for me. The expert guidance and support I received from their team made my weight loss journey so much easier. Thank you!', 'nutritionist_theme' ),
		'avatar' => 'avatars/avatar-6.png',
	),
	array(
		'name'   => __( 'Emily Davis', 'nutritionist_theme' ),
		'quote'  => __( 'I had struggled with my weight for years until I found Nutritionist. Their personalized approach and tailored nutrition plan made all the difference. I\'ve never felt better!', 'nutritionist_theme' ),
		'avatar' => 'avatars/avatar-7.png',
	),
);

$testimonials = nutritionist_theme_collect_groups(
	'home_testimonial',
	3,
	static function ( $group, $i ) use ( $defaults ) {
		$quote = isset( $group['quote'] ) ? trim( (string) $group['quote'] ) : '';
		if ( '' === $quote ) {
			return null;
		}
		$fallback = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : $defaults[0];
		return array(
			'quote'  => $quote,
			'name'   => ! empty( $group['name'] ) ? $group['name'] : $fallback['name'],
			'avatar' => ! empty( $group['avatar'] ) ? $group['avatar'] : $fallback['avatar'],
		);
	},
	$defaults,
	$pid
);

$section_title = nutritionist_theme_get_field( 'home_testimonials_title', __( 'Our Testimonials', 'nutritionist_theme' ), $pid );
$section_intro = nutritionist_theme_get_field(
	'home_testimonials_intro',
	__( 'Our satisfied clients share their success stories and experiences on their journey to better health and well-being.', 'nutritionist_theme' ),
	$pid
);
?>

<section class="section section--testimonials" id="testimonials">
	<div class="container">
		<header class="section__header">
			<h2 class="section__title"><?php echo esc_html( $section_title ); ?></h2>
			<p class="section__intro"><?php echo esc_html( $section_intro ); ?></p>
		</header>

		<div class="testimonials-slider" data-reveal data-testimonials>
			<div class="testimonials-slider__track">
				<?php foreach ( $testimonials as $index => $item ) : ?>
					<blockquote class="testimonial-card<?php echo 0 === $index ? ' is-active' : ''; ?>" data-testimonial-index="<?php echo esc_attr( (string) $index ); ?>">
						<div class="testimonial-card__body">
							<span class="testimonial-card__quote" aria-hidden="true"><i class="fa-solid fa-quote-left"></i></span>
							<p class="testimonial-card__text"><?php echo esc_html( $item['quote'] ); ?></p>
						</div>
						<footer class="testimonial-card__author">
							<img
								src="<?php echo esc_url( nutritionist_theme_media_src( $item['avatar'], is_string( $item['avatar'] ) ? $item['avatar'] : 'avatars/avatar-5.png' ) ); ?>"
								alt=""
								width="60"
								height="60"
								loading="lazy"
							>
							<cite><?php echo esc_html( $item['name'] ); ?></cite>
						</footer>
					</blockquote>
				<?php endforeach; ?>
			</div>

			<div class="testimonials-slider__controls">
				<button type="button" class="testimonials-slider__btn" data-testimonials-prev aria-label="<?php esc_attr_e( 'Previous testimonial', 'nutritionist_theme' ); ?>">
					<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
				</button>
				<div class="testimonials-slider__dots" data-testimonials-dots>
					<?php foreach ( $testimonials as $index => $item ) : ?>
						<button
							type="button"
							class="testimonials-slider__dot<?php echo 0 === $index ? ' is-active' : ''; ?>"
							data-testimonials-dot="<?php echo esc_attr( (string) $index ); ?>"
							aria-label="<?php echo esc_attr( sprintf( __( 'Go to testimonial %d', 'nutritionist_theme' ), $index + 1 ) ); ?>"
						></button>
					<?php endforeach; ?>
				</div>
				<button type="button" class="testimonials-slider__btn" data-testimonials-next aria-label="<?php esc_attr_e( 'Next testimonial', 'nutritionist_theme' ); ?>">
					<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
				</button>
			</div>
		</div>
	</div>
</section>
