/**
 * Team page department tabs.
 */
( function () {
	'use strict';

	const root = document.querySelector( '[data-team-page]' );
	if ( ! root ) {
		return;
	}

	const tabs = Array.from( root.querySelectorAll( '[data-team-tab]' ) );
	const panels = Array.from( root.querySelectorAll( '[data-team-panel]' ) );

	function activate( key ) {
		tabs.forEach( ( tab ) => {
			const active = tab.getAttribute( 'data-team-tab' ) === key;
			tab.classList.toggle( 'is-active', active );
			tab.setAttribute( 'aria-selected', active ? 'true' : 'false' );
		} );

		panels.forEach( ( panel ) => {
			const active = panel.getAttribute( 'data-team-panel' ) === key;
			panel.classList.toggle( 'is-active', active );
			if ( active ) {
				panel.removeAttribute( 'hidden' );
			} else {
				panel.setAttribute( 'hidden', '' );
			}
		} );
	}

	tabs.forEach( ( tab ) => {
		tab.addEventListener( 'click', () => {
			activate( tab.getAttribute( 'data-team-tab' ) );
		} );
	} );
}() );
