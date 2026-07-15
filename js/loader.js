/**
 * Logo loading screen — short brand moment on each full page load.
 * Skips only when the user prefers reduced motion.
 */
( function () {
	'use strict';

	var MIN_MS = 850;
	var MAX_MS = 2200;

	var html = document.documentElement;
	var loader = document.getElementById( 'site-loader' );

	function prefersReducedMotion() {
		return window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	}

	function finish() {
		if ( ! html.classList.contains( 'is-loading' ) && ( ! loader || loader.classList.contains( 'is-done' ) ) ) {
			return;
		}

		if ( loader ) {
			loader.classList.add( 'is-hiding' );
		}

		html.classList.remove( 'is-loading' );
		html.classList.add( 'is-loaded' );

		window.setTimeout( function () {
			if ( loader && loader.parentNode ) {
				loader.classList.add( 'is-done' );
				loader.setAttribute( 'aria-hidden', 'true' );
				loader.parentNode.removeChild( loader );
			}
			document.dispatchEvent( new CustomEvent( 'nutritionist:loaderdone' ) );
		}, prefersReducedMotion() ? 0 : 420 );
	}

	function skipImmediately() {
		html.classList.remove( 'is-loading' );
		html.classList.add( 'is-loaded', 'loader-skip' );
		if ( loader && loader.parentNode ) {
			loader.parentNode.removeChild( loader );
		}
		document.dispatchEvent( new CustomEvent( 'nutritionist:loaderdone' ) );
	}

	if ( ! loader || prefersReducedMotion() ) {
		skipImmediately();
		return;
	}

	var started = Date.now();
	var loadFired = document.readyState === 'complete';
	var finished = false;

	function tryFinish( force ) {
		if ( finished ) {
			return;
		}
		var elapsed = Date.now() - started;
		if ( ! force && elapsed < MIN_MS ) {
			window.setTimeout( function () {
				tryFinish( true );
			}, MIN_MS - elapsed );
			return;
		}
		finished = true;
		if ( loader ) {
			loader.classList.add( 'is-ready' );
		}
		finish();
	}

	window.addEventListener( 'load', function () {
		loadFired = true;
		tryFinish( false );
	} );

	window.setTimeout( function () {
		tryFinish( true );
	}, MAX_MS );

	if ( loadFired ) {
		tryFinish( false );
	}
}() );
