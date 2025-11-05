/**
 * Navigation functionality for Warp Theme
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

(function() {
	'use strict';

	// Mobile Menu Toggle
	const initMobileMenu = () => {
		const menuToggle = document.querySelector('.menu-toggle');
		const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
		const mobileMenuClose = document.querySelector('.mobile-menu-close');

		if (!menuToggle || !mobileMenuOverlay) return;

		// Toggle mobile menu
		menuToggle.addEventListener('click', (e) => {
			e.preventDefault();
			const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';

			menuToggle.setAttribute('aria-expanded', !isExpanded);
			mobileMenuOverlay.classList.toggle('active');
			document.body.style.overflow = !isExpanded ? 'hidden' : '';
		});

		// Close mobile menu
		if (mobileMenuClose) {
			mobileMenuClose.addEventListener('click', () => {
				menuToggle.setAttribute('aria-expanded', 'false');
				mobileMenuOverlay.classList.remove('active');
				document.body.style.overflow = '';
			});
		}

		// Close on overlay click
		mobileMenuOverlay.addEventListener('click', (e) => {
			if (e.target === mobileMenuOverlay) {
				menuToggle.setAttribute('aria-expanded', 'false');
				mobileMenuOverlay.classList.remove('active');
				document.body.style.overflow = '';
			}
		});

		// Close on Escape key
		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape' && mobileMenuOverlay.classList.contains('active')) {
				menuToggle.setAttribute('aria-expanded', 'false');
				mobileMenuOverlay.classList.remove('active');
				document.body.style.overflow = '';
			}
		});
	};

	// Search Modal Toggle
	const initSearchModal = () => {
		const searchToggle = document.querySelector('.search-toggle');
		const searchModal = document.getElementById('search-modal');
		const searchModalClose = document.querySelector('.search-modal-close');
		const searchInput = searchModal?.querySelector('input[type="search"]');

		if (!searchToggle || !searchModal) return;

		// Open search modal
		searchToggle.addEventListener('click', (e) => {
			e.preventDefault();
			searchModal.classList.add('active');
			document.body.style.overflow = 'hidden';

			// Focus on search input
			setTimeout(() => {
				if (searchInput) searchInput.focus();
			}, 100);
		});

		// Close search modal
		if (searchModalClose) {
			searchModalClose.addEventListener('click', () => {
				searchModal.classList.remove('active');
				document.body.style.overflow = '';
			});
		}

		// Close on overlay click
		searchModal.addEventListener('click', (e) => {
			if (e.target === searchModal) {
				searchModal.classList.remove('active');
				document.body.style.overflow = '';
			}
		});

		// Close on Escape key
		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape' && searchModal.classList.contains('active')) {
				searchModal.classList.remove('active');
				document.body.style.overflow = '';
			}
		});
	};

	// Sticky Header
	const initStickyHeader = () => {
		const header = document.querySelector('.site-header');
		if (!header || !header.classList.contains('sticky-header')) return;

		let lastScrollTop = 0;
		const headerHeight = header.offsetHeight;

		window.addEventListener('scroll', () => {
			const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

			if (scrollTop > headerHeight) {
				header.classList.add('scrolled');
			} else {
				header.classList.remove('scrolled');
			}

			lastScrollTop = scrollTop;
		});
	};

	// Submenu Dropdowns
	const initDropdowns = () => {
		const menuItems = document.querySelectorAll('.primary-menu .menu-item-has-children');

		menuItems.forEach(item => {
			const link = item.querySelector('a');
			const submenu = item.querySelector('.sub-menu');

			if (!link || !submenu) return;

			// Toggle on click for mobile
			link.addEventListener('click', (e) => {
				if (window.innerWidth < 810) {
					e.preventDefault();
					item.classList.toggle('open');
				}
			});

			// Hover for desktop
			item.addEventListener('mouseenter', () => {
				if (window.innerWidth >= 810) {
					item.classList.add('open');
				}
			});

			item.addEventListener('mouseleave', () => {
				if (window.innerWidth >= 810) {
					item.classList.remove('open');
				}
			});
		});
	};

	// Accessibility: Focus management
	const initFocusManagement = () => {
		// Trap focus in mobile menu when open
		const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
		if (!mobileMenuOverlay) return;

		const focusableElements = mobileMenuOverlay.querySelectorAll(
			'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled])'
		);

		const firstFocusable = focusableElements[0];
		const lastFocusable = focusableElements[focusableElements.length - 1];

		mobileMenuOverlay.addEventListener('keydown', (e) => {
			if (e.key !== 'Tab') return;

			if (e.shiftKey) {
				// Shift + Tab
				if (document.activeElement === firstFocusable) {
					e.preventDefault();
					lastFocusable.focus();
				}
			} else {
				// Tab
				if (document.activeElement === lastFocusable) {
					e.preventDefault();
					firstFocusable.focus();
				}
			}
		});
	};

	// Initialize all navigation features
	const init = () => {
		initMobileMenu();
		initSearchModal();
		initStickyHeader();
		initDropdowns();
		initFocusManagement();
	};

	// Run on DOM ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}

})();
