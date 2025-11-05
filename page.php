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
		<?php
		// Only add content container if NOT an Elementor page
		$is_elementor = function_exists( 'warp_is_elementor_page' ) && warp_is_elementor_page();
		if ( ! $is_elementor ) :
			?>
			<div class="content-container">
		<?php endif; ?>

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

		<?php if ( ! $is_elementor ) : ?>
			</div><!-- .content-container -->
		<?php endif; ?>
	</main><!-- #primary -->

<?php
get_footer();
