<?php
/**
 * Soft UI single post content
 *
 * @package nutritionist_theme
 */

$categories = get_the_category();
$cat_name   = $categories ? $categories[0]->name : '';
$cat_link   = ( $categories && ! is_wp_error( $categories ) ) ? get_category_link( $categories[0]->term_id ) : '';

$related = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 2,
		'post__not_in'        => array( get_the_ID() ),
		'ignore_sticky_posts' => true,
		'category__in'        => $categories ? wp_list_pluck( $categories, 'term_id' ) : array(),
	)
);
if ( ! $related->have_posts() ) {
	$related = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => 2,
			'post__not_in'        => array( get_the_ID() ),
			'ignore_sticky_posts' => true,
		)
	);
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>
	<div class="container single-post__wrap">
		<div class="single-post__panel">
			<header class="single-post__header">
				<?php if ( $cat_name ) : ?>
					<?php if ( $cat_link ) : ?>
						<a class="single-post__cat" href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat_name ); ?></a>
					<?php else : ?>
						<span class="single-post__cat"><?php echo esc_html( $cat_name ); ?></span>
					<?php endif; ?>
				<?php endif; ?>

				<?php the_title( '<h1 class="single-post__title">', '</h1>' ); ?>

				<p class="single-post__meta">
					<span class="single-post__meta-item">
						<i class="fa-regular fa-calendar" aria-hidden="true"></i>
						<?php echo esc_html( get_the_date() ); ?>
					</span>
					<span class="single-post__meta-item">
						<i class="fa-regular fa-user" aria-hidden="true"></i>
						<?php echo esc_html( get_the_author() ); ?>
					</span>
					<span class="single-post__meta-item">
						<i class="fa-regular fa-clock" aria-hidden="true"></i>
						<?php
						echo esc_html(
							sprintf(
								/* translators: %d: estimated minutes */
								__( '%d min read', 'nutritionist_theme' ),
								max( 3, (int) ceil( str_word_count( wp_strip_all_tags( get_post_field( 'post_content', get_the_ID() ) ) ) / 200 ) )
							)
						);
						?>
					</span>
				</p>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="single-post__media">
					<?php
					the_post_thumbnail(
						'large',
						array(
							'class' => 'single-post__image',
							'alt'   => the_title_attribute( array( 'echo' => false ) ),
						)
					);
					?>
				</figure>
			<?php endif; ?>

			<div class="single-post__content entry-content">
				<?php
				the_content();
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'nutritionist_theme' ) . '</div>',
						'after'  => '</div>',
					)
				);
				?>
			</div>

			<aside class="single-post__cta" data-reveal>
				<img
					class="single-post__cta-mark"
					src="<?php echo esc_url( nutritionist_theme_image_url( 'logo-mark.png' ) ); ?>"
					alt=""
					width="48"
					height="48"
				>
				<div class="single-post__cta-copy">
					<h2 class="single-post__cta-title"><?php esc_html_e( 'Ready for a personalized plan?', 'nutritionist_theme' ); ?></h2>
					<p class="single-post__cta-text"><?php esc_html_e( 'Our certified nutritionists build coaching around your goals, preferences, and real life schedule.', 'nutritionist_theme' ); ?></p>
				</div>
				<a class="btn btn--primary single-post__cta-btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
					<?php esc_html_e( 'Book a Demo', 'nutritionist_theme' ); ?>
				</a>
			</aside>

			<footer class="single-post__footer">
				<a class="btn btn--secondary single-post__back" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">
					<?php esc_html_e( 'Back to Blog', 'nutritionist_theme' ); ?>
				</a>
			</footer>
		</div>

		<?php if ( $related->have_posts() ) : ?>
			<section class="single-related" aria-labelledby="single-related-title">
				<header class="section__header single-related__header">
					<h2 class="section__title" id="single-related-title"><?php esc_html_e( 'Keep Reading', 'nutritionist_theme' ); ?></h2>
					<p class="section__intro"><?php esc_html_e( 'More Soft UI insights to support your nutrition journey.', 'nutritionist_theme' ); ?></p>
				</header>
				<div class="single-related__grid" data-reveal-stagger>
					<?php
					while ( $related->have_posts() ) :
						$related->the_post();
						$rel_cats = get_the_category();
						$rel_cat  = $rel_cats ? $rel_cats[0]->name : '';
						?>
						<article class="single-related__card" data-reveal>
							<a class="single-related__media" href="<?php the_permalink(); ?>">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'medium_large', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) );
								}
								?>
							</a>
							<?php if ( $rel_cat ) : ?>
								<p class="single-related__cat"><?php echo esc_html( $rel_cat ); ?></p>
							<?php endif; ?>
							<h3 class="single-related__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<p class="single-related__excerpt"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
						</article>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</section>
		<?php endif; ?>

		<?php
		the_post_navigation(
			array(
				'prev_text' => '<span class="single-post__nav-label">' . esc_html__( 'Previous', 'nutritionist_theme' ) . '</span><span class="single-post__nav-title">%title</span>',
				'next_text' => '<span class="single-post__nav-label">' . esc_html__( 'Next', 'nutritionist_theme' ) . '</span><span class="single-post__nav-title">%title</span>',
			)
		);
		?>
	</div>
</article>
