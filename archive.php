<?php
/**
 * The template for displaying archive pages
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
			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<div class="posts-grid">
					<?php
					// Start the Loop
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content/content', get_post_type() );

					endwhile;
					?>
				</div><!-- .posts-grid -->

				<?php
				// Previous/next page navigation
				the_posts_pagination(
					array(
						'mid_size'  => 2,
						'prev_text' => sprintf(
							'%s <span class="nav-prev-text">%s</span>',
							'<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
							__( 'Previous', 'warp-theme' )
						),
						'next_text' => sprintf(
							'<span class="nav-next-text">%s</span> %s',
							__( 'Next', 'warp-theme' ),
							'<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'
						),
					)
				);

			else :

				get_template_part( 'template-parts/content/content', 'none' );

			endif;
			?>
		</div><!-- .content-container -->
	</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
