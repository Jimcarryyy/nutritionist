<?php
/**
 * The front page template
 *
 * @package nutritionist_theme
 */

get_header();
?>

	<main id="primary" class="site-main site-main--front">

		<?php get_template_part( 'template-parts/content', 'hero' ); ?>
		<?php get_template_part( 'template-parts/content', 'features' ); ?>
		<?php get_template_part( 'template-parts/content', 'blogs' ); ?>
		<?php get_template_part( 'template-parts/content', 'testimonials' ); ?>
		<?php get_template_part( 'template-parts/content', 'pricing' ); ?>

	</main><!-- #main -->

<?php
get_footer();
