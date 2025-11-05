<?php
/**
 * The template for displaying 404 pages (not found)
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
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( '404', 'warp-theme' ); ?></h1>
					<p class="error-subtitle"><?php esc_html_e( 'Page Not Found', 'warp-theme' ); ?></p>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'warp-theme' ); ?></p>

					<?php get_search_form(); ?>

					<div class="error-404-actions">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button button-primary">
							<?php esc_html_e( 'Go to Homepage', 'warp-theme' ); ?>
						</a>
					</div>

					<?php
					// Show recent posts
					$recent_posts = wp_get_recent_posts(
						array(
							'numberposts' => 3,
							'post_status' => 'publish',
						)
					);

					if ( ! empty( $recent_posts ) ) :
						?>
						<div class="widget widget_recent_entries">
							<h2 class="widget-title"><?php esc_html_e( 'Recent Posts', 'warp-theme' ); ?></h2>
							<ul>
								<?php
								foreach ( $recent_posts as $recent ) :
									?>
									<li>
										<a href="<?php echo esc_url( get_permalink( $recent['ID'] ) ); ?>">
											<?php echo esc_html( $recent['post_title'] ); ?>
										</a>
									</li>
									<?php
								endforeach;
								?>
							</ul>
						</div>
						<?php
					endif;

					// Show categories
					if ( has_nav_menu( 'primary' ) ) :
						?>
						<div class="widget widget_categories">
							<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'warp-theme' ); ?></h2>
							<ul>
								<?php
								wp_list_categories(
									array(
										'orderby'    => 'count',
										'order'      => 'DESC',
										'show_count' => 1,
										'title_li'   => '',
										'number'     => 10,
									)
								);
								?>
							</ul>
						</div>
						<?php
					endif;
					?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</div><!-- .content-container -->
	</main><!-- #primary -->

<?php
get_footer();
