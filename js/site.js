/**
 * Site-wide interactivity: Go To Top, mobile menu close, contact form UX, scroll reveal, hero entrance.
 */
( function () {
	'use strict';

	const prefersReducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	function initGoToTop() {
		const link = document.querySelector( '.site-footer__totop' );
		if ( ! link ) {
			return;
		}

		link.addEventListener( 'click', function ( event ) {
			event.preventDefault();
			window.scrollTo( {
				top: 0,
				behavior: prefersReducedMotion ? 'auto' : 'smooth',
			} );
			const page = document.getElementById( 'page' );
			if ( page ) {
				page.focus( { preventScroll: true } );
			}
		} );
	}

	function initMobileMenuClose() {
		const nav = document.getElementById( 'site-navigation' );
		const menu = document.getElementById( 'primary-menu' );
		if ( ! nav || ! menu ) {
			return;
		}

		const button = nav.querySelector( '.menu-toggle' );

		menu.querySelectorAll( 'a' ).forEach( function ( anchor ) {
			anchor.addEventListener( 'click', function () {
				nav.classList.remove( 'toggled' );
				if ( button ) {
					button.setAttribute( 'aria-expanded', 'false' );
				}
			} );
		} );
	}

	function initContactForm() {
		const form = document.querySelector( '.contact-form' );
		if ( ! form ) {
			return;
		}

		const textarea = form.querySelector( 'textarea[name="message"]' );
		const hint = form.querySelector( '[data-contact-hint]' );
		const status = form.querySelector( '[data-contact-status]' );
		const planInput = form.querySelector( '[data-contact-plan]' );
		const billingInput = form.querySelector( '[data-contact-billing]' );
		const planBanner = form.querySelector( '[data-contact-plan-banner]' );
		const planLabel = form.querySelector( '[data-contact-plan-label]' );
		const max = textarea ? Number( textarea.getAttribute( 'maxlength' ) ) || 250 : 250;
		const allowedPlans = [ 'Basic Plan', 'Premium Plan', 'Ultimate Plan' ];

		function setStatus( type, message ) {
			if ( ! status ) {
				return;
			}
			status.hidden = ! message;
			status.textContent = message || '';
			status.classList.remove( 'is-success', 'is-error' );
			if ( type ) {
				status.classList.add( 'is-' + type );
			}
		}

		function updateHint() {
			if ( ! textarea || ! hint ) {
				return;
			}
			const remaining = max - textarea.value.length;
			hint.textContent = remaining + ' / ' + max;
		}

		function clearPlanSelection() {
			if ( planInput ) {
				planInput.value = '';
				planInput.defaultValue = '';
			}
			if ( billingInput ) {
				billingInput.value = '';
				billingInput.defaultValue = '';
			}
			if ( planBanner ) {
				planBanner.hidden = true;
			}
			if ( planLabel ) {
				planLabel.textContent = '';
			}
		}

		function resetFormFields() {
			form.querySelectorAll( 'input:not([data-contact-honeypot]), textarea' ).forEach( function ( field ) {
				if ( field.type === 'hidden' ) {
					field.value = '';
					field.defaultValue = '';
					return;
				}
				if ( field.type === 'checkbox' || field.type === 'radio' ) {
					field.checked = false;
					return;
				}
				field.value = '';
				field.defaultValue = '';
			} );
			clearPlanSelection();
			updateHint();
		}

		( function applyPlanFromQuery() {
			const params = new URLSearchParams( window.location.search );
			const plan = params.get( 'plan' ) || '';
			let billing = params.get( 'billing' ) || '';
			if ( ! allowedPlans.includes( plan ) ) {
				return;
			}
			if ( billing !== 'monthly' && billing !== 'yearly' ) {
				billing = 'monthly';
			}
			if ( planInput ) {
				planInput.value = plan;
			}
			if ( billingInput ) {
				billingInput.value = billing;
			}
			const billingLabel = billing === 'yearly' ? 'Yearly' : 'Monthly';
			if ( planBanner && planLabel ) {
				planLabel.textContent = plan + ' · ' + billingLabel;
				planBanner.hidden = false;
			}
			if ( textarea && ! textarea.value.trim() ) {
				textarea.value = "I'm interested in the " + plan + ' (' + billingLabel + ').';
			}
		}() );

		if ( textarea && hint ) {
			updateHint();
			textarea.addEventListener( 'input', updateHint );
		}

		form.addEventListener( 'submit', function ( event ) {
			event.preventDefault();
			setStatus( '', '' );

			if ( ! form.checkValidity() ) {
				form.reportValidity();
				setStatus( 'error', 'Please fill in all required fields correctly.' );
				return;
			}

			const email = form.querySelector( 'input[name="email"]' );
			const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			if ( email && ! emailPattern.test( email.value.trim() ) ) {
				setStatus( 'error', 'Please enter a valid email address.' );
				email.focus();
				return;
			}

			const cfg = typeof window.nutritionistContact === 'object' ? window.nutritionistContact : null;
			if ( ! cfg || ! cfg.restUrl || ! cfg.nonce ) {
				setStatus( 'error', 'Contact form is not configured. Please refresh the page.' );
				return;
			}

			const submitBtn = form.querySelector( '[type="submit"]' );
			if ( submitBtn ) {
				submitBtn.disabled = true;
			}

			const payload = {
				full_name: ( form.querySelector( '[name="full_name"]' ) || {} ).value || '',
				email: email.value.trim(),
				phone: ( form.querySelector( '[name="phone"]' ) || {} ).value || '',
				message: ( textarea && textarea.value ) || '',
				nt_hp: ( form.querySelector( '[data-contact-honeypot]' ) || {} ).value || '',
				plan: ( planInput && planInput.value ) || '',
				billing: ( billingInput && billingInput.value ) || '',
			};

			fetch( cfg.restUrl, {
				method: 'POST',
				credentials: 'same-origin',
				headers: {
					'Content-Type': 'application/json',
					'X-WP-Nonce': cfg.nonce,
				},
				body: JSON.stringify( payload ),
			} )
				.then( function ( response ) {
					return response.json().then( function ( data ) {
						return { ok: response.ok, data: data };
					} );
				} )
				.then( function ( result ) {
					if ( ! result.ok || ! result.data || ! result.data.success ) {
						const msg =
							( result.data && ( result.data.message || ( result.data.data && result.data.data.message ) ) ) ||
							'Could not send your message. Please try again.';
						setStatus( 'error', msg );
						return;
					}
					setStatus( 'success', result.data.message || 'Thanks! Your message has been sent.' );
					resetFormFields();
				} )
				.catch( function () {
					setStatus( 'error', 'Network error. Please try again.' );
				} )
				.finally( function () {
					if ( submitBtn ) {
						submitBtn.disabled = false;
					}
				} );
		} );
	}

	function applyStaggerDelays() {
		document.querySelectorAll( '[data-reveal-stagger]' ).forEach( function ( parent ) {
			const children = parent.querySelectorAll( ':scope > [data-reveal]' );
			children.forEach( function ( child, index ) {
				child.style.transitionDelay = prefersReducedMotion ? '0ms' : index * 60 + 'ms';
			} );
		} );
	}

	function initReveal() {
		const items = Array.from( document.querySelectorAll( '[data-reveal]' ) );
		if ( ! items.length ) {
			return;
		}

		applyStaggerDelays();

		if ( prefersReducedMotion || ! ( 'IntersectionObserver' in window ) ) {
			items.forEach( function ( el ) {
				el.classList.add( 'is-reveal', 'is-visible' );
			} );
			return;
		}

		items.forEach( function ( el ) {
			if ( ! el.classList.contains( 'is-reveal--fade' ) && ! el.classList.contains( 'is-reveal--scale' ) ) {
				el.classList.add( 'is-reveal', 'is-reveal--up' );
			} else {
				el.classList.add( 'is-reveal' );
			}
		} );

		const observer = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( ! entry.isIntersecting ) {
						return;
					}
					entry.target.classList.add( 'is-visible' );
					observer.unobserve( entry.target );
				} );
			},
			{
				threshold: 0.12,
				rootMargin: '0px 0px -6% 0px',
			}
		);

		items.forEach( function ( el ) {
			observer.observe( el );
		} );
	}

	function activateHeroEntrance() {
		document.querySelectorAll( '[data-hero-enter]' ).forEach( function ( el ) {
			el.classList.add( 'is-hero-ready' );
		} );
	}

	function initHeroEntrance() {
		if ( prefersReducedMotion ) {
			activateHeroEntrance();
			return;
		}

		if ( document.documentElement.classList.contains( 'is-loaded' ) || document.documentElement.classList.contains( 'loader-skip' ) ) {
			window.requestAnimationFrame( activateHeroEntrance );
			return;
		}

		document.addEventListener( 'nutritionist:loaderdone', activateHeroEntrance, { once: true } );
		window.setTimeout( activateHeroEntrance, 2800 );
	}

	function initCookieConsent() {
		const banner = document.querySelector( '[data-cookie-consent]' );
		if ( ! banner ) {
			return;
		}

		const STORAGE_KEY = 'nutritionist_cookie_consent';
		const acceptBtn = banner.querySelector( '[data-cookie-accept]' );
		const declineBtn = banner.querySelector( '[data-cookie-decline]' );

		function getChoice() {
			try {
				return window.localStorage.getItem( STORAGE_KEY ) || '';
			} catch ( e ) {
				return '';
			}
		}

		function setChoice( value ) {
			try {
				window.localStorage.setItem( STORAGE_KEY, value );
			} catch ( e ) {
				// Ignore private-mode storage failures.
			}
		}

		function hideBanner() {
			banner.classList.remove( 'is-visible' );
			window.setTimeout( function () {
				banner.hidden = true;
			}, prefersReducedMotion ? 0 : 320 );
		}

		function showBanner() {
			banner.hidden = false;
			window.requestAnimationFrame( function () {
				banner.classList.add( 'is-visible' );
			} );
		}

		function dismiss( value ) {
			setChoice( value );
			hideBanner();
		}

		if ( acceptBtn ) {
			acceptBtn.addEventListener( 'click', function () {
				dismiss( 'accepted' );
			} );
		}
		if ( declineBtn ) {
			declineBtn.addEventListener( 'click', function () {
				dismiss( 'declined' );
			} );
		}

		if ( getChoice() ) {
			return;
		}

		function revealAfterLoader() {
			window.setTimeout( showBanner, prefersReducedMotion ? 80 : 450 );
		}

		if (
			document.documentElement.classList.contains( 'is-loaded' ) ||
			document.documentElement.classList.contains( 'loader-skip' )
		) {
			revealAfterLoader();
			return;
		}

		document.addEventListener( 'nutritionist:loaderdone', revealAfterLoader, { once: true } );
		window.setTimeout( revealAfterLoader, 2800 );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		initGoToTop();
		initMobileMenuClose();
		initContactForm();
		initReveal();
		initHeroEntrance();
		initCookieConsent();
	} );
}() );
