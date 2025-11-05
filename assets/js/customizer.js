/**
 * Customizer live preview
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

(function($) {
	'use strict';

	// Site title
	wp.customize('blogname', function(value) {
		value.bind(function(to) {
			$('.site-title a').text(to);
		});
	});

	// Site description
	wp.customize('blogdescription', function(value) {
		value.bind(function(to) {
			$('.site-description').text(to);
		});
	});

	// Header text color
	wp.customize('header_textcolor', function(value) {
		value.bind(function(to) {
			if ('blank' === to) {
				$('.site-title, .site-description').css({
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				});
			} else {
				$('.site-title, .site-description').css({
					'clip': 'auto',
					'position': 'relative'
				});
				$('.site-title a, .site-description').css({
					'color': to
				});
			}
		});
	});

	// Body font size
	wp.customize('warp_body_font_size', function(value) {
		value.bind(function(to) {
			$('body').css('font-size', to + 'px');
		});
	});

	// Container width
	wp.customize('warp_container_width', function(value) {
		value.bind(function(to) {
			const style = '<style id="warp-container-width">:root { --warp-container-width: ' + to + 'px; }</style>';
			$('#warp-container-width').remove();
			$('head').append(style);
		});
	});

	// Copyright text
	wp.customize('warp_copyright_text', function(value) {
		value.bind(function(to) {
			$('.site-info .copyright').html(to);
		});
	});

})(jQuery);
