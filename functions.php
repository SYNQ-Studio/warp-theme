<?php
/**
 * Warp Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Define theme constants
 */
define( 'WARP_THEME_VERSION', '1.0.0' );
define( 'WARP_THEME_DIR', get_template_directory() );
define( 'WARP_THEME_URI', get_template_directory_uri() );

/**
 * Theme setup and configuration
 */
require_once WARP_THEME_DIR . '/inc/theme-setup.php';

/**
 * Enqueue scripts and styles
 */
require_once WARP_THEME_DIR . '/inc/enqueue-scripts.php';

/**
 * Elementor compatibility and custom widgets
 */
require_once WARP_THEME_DIR . '/inc/elementor-support.php';

/**
 * Customizer options
 */
require_once WARP_THEME_DIR . '/inc/customizer.php';

/**
 * Custom template tags for this theme
 */
if ( ! function_exists( 'warp_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time
	 */
	function warp_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date */
			esc_html_x( 'Posted on %s', 'post date', 'warp-theme' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'warp_posted_by' ) ) {
	/**
	 * Prints HTML with meta information for the current author
	 */
	function warp_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author */
			esc_html_x( 'by %s', 'post author', 'warp-theme' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'warp_entry_footer' ) ) {
	/**
	 * Prints HTML with meta information for categories, tags and comments
	 */
	function warp_entry_footer() {
		// Hide category and tag text for pages
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'warp-theme' ) );
			if ( $categories_list ) {
				/* translators: %s: list of categories */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'warp-theme' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'warp-theme' ) );
			if ( $tags_list ) {
				/* translators: %s: list of tags */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'warp-theme' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'warp-theme' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'warp-theme' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
}

if ( ! function_exists( 'warp_post_thumbnail' ) ) {
	/**
	 * Displays an optional post thumbnail
	 */
	function warp_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div>
			<?php
		else :
			?>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail(
					'post-thumbnail',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
				?>
			</a>
			<?php
		endif;
	}
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments
 */
function warp_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'warp_pingback_header' );
