/**
 * Front-page interactions: testimonials carousel + pricing toggle.
 */
( function () {
	'use strict';

	function initTestimonials() {
		const root = document.querySelector( '[data-testimonials]' );
		if ( ! root ) {
			return;
		}

		const cards = Array.from( root.querySelectorAll( '.testimonial-card' ) );
		const dots = Array.from( root.querySelectorAll( '[data-testimonials-dot]' ) );
		const prev = root.querySelector( '[data-testimonials-prev]' );
		const next = root.querySelector( '[data-testimonials-next]' );
		let index = 0;

		function show( nextIndex ) {
			index = ( nextIndex + cards.length ) % cards.length;
			cards.forEach( ( card, i ) => {
				card.classList.toggle( 'is-active', i === index );
			} );
			dots.forEach( ( dot, i ) => {
				dot.classList.toggle( 'is-active', i === index );
			} );
		}

		if ( prev ) {
			prev.addEventListener( 'click', () => show( index - 1 ) );
		}
		if ( next ) {
			next.addEventListener( 'click', () => show( index + 1 ) );
		}
		dots.forEach( ( dot ) => {
			dot.addEventListener( 'click', () => {
				show( Number( dot.getAttribute( 'data-testimonials-dot' ) ) );
			} );
		} );
	}

	function initPricingToggle() {
		const root = document.querySelector( '[data-pricing-toggle]' );
		if ( ! root ) {
			return;
		}

		const buttons = Array.from( root.querySelectorAll( '[data-billing]' ) );
		const cards = Array.from( document.querySelectorAll( '.pricing-card' ) );

		function setBilling( mode ) {
			buttons.forEach( ( btn ) => {
				const active = btn.getAttribute( 'data-billing' ) === mode;
				btn.classList.toggle( 'is-active', active );
				btn.setAttribute( 'aria-pressed', active ? 'true' : 'false' );
			} );

			cards.forEach( ( card ) => {
				const monthly = Number( card.getAttribute( 'data-monthly-price' ) );
				const amount = card.querySelector( '[data-price-amount]' );
				const period = card.querySelector( '[data-price-period]' );
				const cta = card.querySelector( '[data-plan-cta]' );
				if ( ! amount || ! period ) {
					return;
				}
				if ( 'yearly' === mode ) {
					amount.textContent = '$' + Math.round( monthly * 12 * 0.5 );
					period.textContent = '/year';
				} else {
					amount.textContent = '$' + monthly;
					period.textContent = '/month';
				}
				if ( cta ) {
					const planName = cta.getAttribute( 'data-plan-name' ) || '';
					const url = new URL( cta.getAttribute( 'href' ), window.location.origin );
					url.searchParams.set( 'plan', planName );
					url.searchParams.set( 'billing', mode );
					cta.setAttribute( 'href', url.pathname + url.search );
				}
			} );
		}

		buttons.forEach( ( btn ) => {
			btn.addEventListener( 'click', () => {
				setBilling( btn.getAttribute( 'data-billing' ) );
			} );
		} );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		initTestimonials();
		initPricingToggle();
	} );
}() );
