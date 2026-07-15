/**
 * Pricing page: billing toggle + FAQ accordion (single-open).
 */
( function () {
	'use strict';

	function initPricingToggle() {
		const root = document.querySelector( '[data-pricing-toggle]' );
		if ( ! root ) {
			return;
		}

		const buttons = Array.from( root.querySelectorAll( '[data-billing]' ) );
		const cards = Array.from( document.querySelectorAll( '.pricing-page-card' ) );

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

	function initFaq() {
		const list = document.querySelector( '[data-pricing-faq]' );
		if ( ! list ) {
			return;
		}

		const items = Array.from( list.querySelectorAll( 'details.pricing-faq__item' ) );

		items.forEach( ( item ) => {
			item.addEventListener( 'toggle', () => {
				if ( ! item.open ) {
					return;
				}
				items.forEach( ( other ) => {
					if ( other !== item ) {
						other.open = false;
					}
				} );
			} );
		} );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		initPricingToggle();
		initFaq();
	} );
}() );
