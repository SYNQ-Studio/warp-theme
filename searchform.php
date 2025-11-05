<?php
/**
 * Search form template
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="search-form-<?php echo esc_attr( uniqid() ); ?>">
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'warp-theme' ); ?></span>
		<input
			type="search"
			id="search-form-<?php echo esc_attr( uniqid() ); ?>"
			class="search-field"
			placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'warp-theme' ); ?>"
			value="<?php echo get_search_query(); ?>"
			name="s"
		/>
	</label>
	<button type="submit" class="search-submit">
		<span class="screen-reader-text"><?php esc_html_e( 'Search', 'warp-theme' ); ?></span>
		<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M19 19L13 13M15 8C15 11.866 11.866 15 8 15C4.13401 15 1 11.866 1 8C1 4.13401 4.13401 1 8 1C11.866 1 15 4.13401 15 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
	</button>
</form>
