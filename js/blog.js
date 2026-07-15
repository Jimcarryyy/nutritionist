/**
 * Blog page category filters.
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		const bar = document.querySelector( '[data-blog-filters]' );
		const grid = document.querySelector( '[data-blog-grid]' );
		if ( ! bar || ! grid ) {
			return;
		}

		const buttons = Array.from( bar.querySelectorAll( '[data-filter]' ) );
		const cards = Array.from( grid.querySelectorAll( '[data-category]' ) );
		const reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		function setFilter( filter ) {
			buttons.forEach( ( btn ) => {
				const active = btn.getAttribute( 'data-filter' ) === filter;
				btn.classList.toggle( 'is-active', active );
				btn.setAttribute( 'aria-pressed', active ? 'true' : 'false' );
			} );

			cards.forEach( ( card ) => {
				const show = 'all' === filter || card.getAttribute( 'data-category' ) === filter;

				if ( show ) {
					card.hidden = false;
					card.classList.remove( 'is-filtering-out' );
					return;
				}

				if ( reduceMotion || card.hidden ) {
					card.hidden = true;
					card.classList.remove( 'is-filtering-out' );
					return;
				}

				card.classList.add( 'is-filtering-out' );
				window.setTimeout( function () {
					if ( card.classList.contains( 'is-filtering-out' ) ) {
						card.hidden = true;
						card.classList.remove( 'is-filtering-out' );
					}
				}, 280 );
			} );
		}

		buttons.forEach( ( btn ) => {
			btn.addEventListener( 'click', () => {
				setFilter( btn.getAttribute( 'data-filter' ) );
			} );
		} );
	} );
}() );
