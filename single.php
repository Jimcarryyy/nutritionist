<?php
/**
 * Single blog post — Soft UI layout
 *
 * @package nutritionist_theme
 */

get_header();
?>

	<main id="primary" class="site-main site-main--single">

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'single' );
		endwhile;
		?>

	</main><!-- #main -->

<?php
get_footer();
