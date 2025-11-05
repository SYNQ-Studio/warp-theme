/**
 * Animation effects for Warp Theme
 *
 * @package Warp_Theme
 * @since 1.0.0
 */

(function() {
	'use strict';

	// Intersection Observer for fade-in animations
	const initScrollAnimations = () => {
		const animatedElements = document.querySelectorAll('.animate-on-scroll');

		if (!animatedElements.length) return;

		const observerOptions = {
			root: null,
			rootMargin: '0px',
			threshold: 0.1
		};

		const observer = new IntersectionObserver((entries) => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					entry.target.classList.add('animated');
					observer.unobserve(entry.target);
				}
			});
		}, observerOptions);

		animatedElements.forEach(element => {
			observer.observe(element);
		});
	};

	// Smooth scroll for anchor links
	const initSmoothScroll = () => {
		// Check if smooth scroll is enabled
		if (!document.body.classList.contains('smooth-scroll')) return;

		const anchorLinks = document.querySelectorAll('a[href^="#"]');

		anchorLinks.forEach(link => {
			link.addEventListener('click', (e) => {
				const targetId = link.getAttribute('href');

				// Skip if it's just "#"
				if (targetId === '#') return;

				const targetElement = document.querySelector(targetId);

				if (targetElement) {
					e.preventDefault();

					const headerOffset = document.querySelector('.site-header')?.offsetHeight || 0;
					const elementPosition = targetElement.getBoundingClientRect().top;
					const offsetPosition = elementPosition + window.pageYOffset - headerOffset - 20;

					window.scrollTo({
						top: offsetPosition,
						behavior: 'smooth'
					});

					// Update URL without jumping
					if (history.pushState) {
						history.pushState(null, null, targetId);
					}

					// Focus on target element for accessibility
					targetElement.focus({ preventScroll: true });
				}
			});
		});
	};

	// Parallax effect for hero sections
	const initParallax = () => {
		const parallaxElements = document.querySelectorAll('.parallax');

		if (!parallaxElements.length) return;

		window.addEventListener('scroll', () => {
			const scrolled = window.pageYOffset;

			parallaxElements.forEach(element => {
				const speed = element.dataset.parallaxSpeed || 0.5;
				const yPos = -(scrolled * speed);
				element.style.transform = `translate3d(0, ${yPos}px, 0)`;
			});
		});
	};

	// Fade in elements on page load
	const initPageLoadAnimations = () => {
		// Add fade-in class to body after load
		window.addEventListener('load', () => {
			document.body.classList.add('loaded');
		});
	};

	// Counter animation for numbers
	const initCounters = () => {
		const counters = document.querySelectorAll('.counter');

		if (!counters.length) return;

		const animateCounter = (counter) => {
			const target = parseFloat(counter.getAttribute('data-target'));
			const duration = parseFloat(counter.getAttribute('data-duration')) || 2000;
			const step = target / (duration / 16); // 60fps
			let current = 0;

			const updateCounter = () => {
				current += step;
				if (current < target) {
					counter.textContent = Math.floor(current);
					requestAnimationFrame(updateCounter);
				} else {
					counter.textContent = target;
				}
			};

			updateCounter();
		};

		const observerOptions = {
			root: null,
			rootMargin: '0px',
			threshold: 0.5
		};

		const observer = new IntersectionObserver((entries) => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					animateCounter(entry.target);
					observer.unobserve(entry.target);
				}
			});
		}, observerOptions);

		counters.forEach(counter => {
			observer.observe(counter);
		});
	};

	// Typing effect for hero text
	const initTypingEffect = () => {
		const typingElements = document.querySelectorAll('.typing-effect');

		if (!typingElements.length) return;

		typingElements.forEach(element => {
			const text = element.textContent;
			const speed = parseInt(element.getAttribute('data-typing-speed')) || 50;
			element.textContent = '';
			element.style.visibility = 'visible';

			let i = 0;
			const typeWriter = () => {
				if (i < text.length) {
					element.textContent += text.charAt(i);
					i++;
					setTimeout(typeWriter, speed);
				}
			};

			// Start typing after a small delay
			setTimeout(typeWriter, 500);
		});
	};

	// Image lazy loading with fade-in
	const initLazyImages = () => {
		const lazyImages = document.querySelectorAll('img[data-src]');

		if (!lazyImages.length) return;

		const imageObserver = new IntersectionObserver((entries) => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					const img = entry.target;
					img.src = img.dataset.src;
					img.classList.add('loaded');
					imageObserver.unobserve(img);
				}
			});
		});

		lazyImages.forEach(img => {
			imageObserver.observe(img);
		});
	};

	// Add CSS classes for animations
	const addAnimationStyles = () => {
		// Check if style already exists
		if (document.getElementById('warp-animation-styles')) return;

		const style = document.createElement('style');
		style.id = 'warp-animation-styles';
		style.textContent = `
			.animate-on-scroll {
				opacity: 0;
				transform: translateY(30px);
				transition: opacity 0.6s ease-out, transform 0.6s ease-out;
			}
			.animate-on-scroll.animated {
				opacity: 1;
				transform: translateY(0);
			}
			.fade-in {
				animation: fadeIn 0.6s ease-out;
			}
			@keyframes fadeIn {
				from {
					opacity: 0;
					transform: translateY(20px);
				}
				to {
					opacity: 1;
					transform: translateY(0);
				}
			}
			img[data-src] {
				opacity: 0;
				transition: opacity 0.3s ease-in;
			}
			img[data-src].loaded {
				opacity: 1;
			}
			.typing-effect {
				visibility: hidden;
			}
		`;
		document.head.appendChild(style);
	};

	// Initialize all animations
	const init = () => {
		addAnimationStyles();
		initScrollAnimations();
		initSmoothScroll();
		initParallax();
		initPageLoadAnimations();
		initCounters();
		initTypingEffect();
		initLazyImages();
	};

	// Run on DOM ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}

})();
