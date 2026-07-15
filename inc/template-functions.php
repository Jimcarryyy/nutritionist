<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package nutritionist_theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function nutritionist_theme_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'nutritionist_theme_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function nutritionist_theme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'nutritionist_theme_pingback_header' );

/**
 * Soft UI blog category slug => label map used by filters.
 *
 * @return array<string, string>
 */
function nutritionist_theme_blog_category_map() {
	return array(
		'all'     => __( 'All', 'nutritionist_theme' ),
		'weight'  => __( 'Weight Loss Tips', 'nutritionist_theme' ),
		'eating'  => __( 'Healthy Eating', 'nutritionist_theme' ),
		'fitness' => __( 'Fitness and Exercise', 'nutritionist_theme' ),
		'mindset' => __( 'Mindset and Motivation', 'nutritionist_theme' ),
		'recipes' => __( 'Recipes and Meal Planning', 'nutritionist_theme' ),
	);
}

/**
 * Build Soft UI blog card data from published WP posts in Soft UI categories.
 *
 * @param int $limit Max posts (0 = no limit).
 * @return array<int, array{cat:string,label:string,title:string,text:string,image:string,link:string,alt:string,date:string,author:string}>
 */
function nutritionist_theme_get_wp_blog_cards( $limit = 0 ) {
	$slugs = array( 'weight', 'eating', 'fitness', 'mindset', 'recipes' );
	$labels = nutritionist_theme_blog_category_map();

	$args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $limit > 0 ? (int) $limit : -1,
		'ignore_sticky_posts' => true,
		'tax_query'           => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $slugs,
			),
		),
	);

	$query = new WP_Query( $args );
	if ( ! $query->have_posts() ) {
		return array();
	}

	$cards = array();
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_id = get_the_ID();
		$terms   = get_the_terms( $post_id, 'category' );
		$cat     = 'weight';
		$label   = $labels['weight'];

		if ( is_array( $terms ) ) {
			foreach ( $terms as $term ) {
				if ( in_array( $term->slug, $slugs, true ) ) {
					$cat   = $term->slug;
					$label = isset( $labels[ $cat ] ) ? $labels[ $cat ] : $term->name;
					break;
				}
			}
		}

		$image = get_the_post_thumbnail_url( $post_id, 'large' );
		if ( ! $image ) {
			$image = nutritionist_theme_image_url( 'blogpage/post-1.png' );
		}

		$cards[] = array(
			'cat'    => $cat,
			'label'  => $label,
			'title'  => get_the_title(),
			'text'   => get_the_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : wp_trim_words( wp_strip_all_tags( get_the_content( null, false, $post_id ) ), 28 ),
			'image'  => $image,
			'link'   => get_permalink( $post_id ),
			'alt'    => get_the_title(),
			'date'   => get_the_date(),
			'author' => get_the_author(),
		);
	}
	wp_reset_postdata();

	return $cards;
}
