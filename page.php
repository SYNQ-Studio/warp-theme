<?php
/**
 * The template for displaying all pages
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

	<main id="primary" class="site-main">
		<div class="content-container">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop
			?>
		</div><!-- .content-container -->
	</main><!-- #primary -->

<?php
get_footer();
