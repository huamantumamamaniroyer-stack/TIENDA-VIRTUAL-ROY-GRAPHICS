/**
 * Automotive Car Dealer - Getting Started page.
 * In-page tabs and coupon copy button.
 */
( function () {
	'use strict';

	var root = document.querySelector( '.wprev-getstart' );
	if ( ! root ) {
		return;
	}

	var i18n = window.wprGetstart || { copied: 'Copied!', copy: 'Copy Code' };

	/* Tabs ---------------------------------------------------------------- */

	var tabs = root.querySelectorAll( '[data-wprev-tab]' );
	var panels = root.querySelectorAll( '[data-wprev-panel]' );

	function activate( id, updateUrl ) {
		var found = false;

		panels.forEach( function ( panel ) {
			var match = panel.getAttribute( 'data-wprev-panel' ) === id;
			panel.hidden = ! match;
			found = found || match;
		} );

		if ( ! found ) {
			return false;
		}

		tabs.forEach( function ( tab ) {
			var match = tab.getAttribute( 'data-wprev-tab' ) === id;
			tab.classList.toggle( 'is-active', match );
			if ( match ) {
				tab.setAttribute( 'aria-current', 'page' );
				if ( tab.scrollIntoView ) {
					tab.scrollIntoView( { block: 'nearest', inline: 'nearest' } );
				}
			} else {
				tab.removeAttribute( 'aria-current' );
			}
		} );

		if ( updateUrl && window.history && window.history.replaceState ) {
			var url = new URL( window.location.href );
			url.searchParams.set( 'section', id );
			window.history.replaceState( null, '', url.toString() );
		}

		return true;
	}

	tabs.forEach( function ( tab ) {
		tab.addEventListener( 'click', function ( event ) {
			if ( event.metaKey || event.ctrlKey || event.shiftKey || event.button === 1 ) {
				return;
			}
			if ( activate( tab.getAttribute( 'data-wprev-tab' ), true ) ) {
				event.preventDefault();
			}
		} );
	} );

	/* Coupon copy --------------------------------------------------------- */

	function legacyCopy( text ) {
		return new Promise( function ( resolve, reject ) {
			var field = document.createElement( 'textarea' );
			field.value = text;
			field.setAttribute( 'readonly', '' );
			field.style.position = 'fixed';
			field.style.opacity = '0';
			document.body.appendChild( field );
			field.select();
			try {
				document.execCommand( 'copy' ) ? resolve() : reject();
			} catch ( e ) {
				reject( e );
			}
			document.body.removeChild( field );
		} );
	}

	// The Clipboard API can be refused (permissions, iframes), so fall back instead of rejecting.
	function copyText( text ) {
		if ( navigator.clipboard && window.isSecureContext ) {
			return navigator.clipboard.writeText( text ).catch( function () {
				return legacyCopy( text );
			} );
		}

		return legacyCopy( text );
	}

	// Last resort: select the code so it can be copied by hand.
	function selectCode( code ) {
		var selection = window.getSelection();
		var range = document.createRange();

		if ( ! code || ! selection ) {
			return;
		}

		range.selectNodeContents( code );
		selection.removeAllRanges();
		selection.addRange( range );
	}

	root.querySelectorAll( '[data-wprev-copy]' ).forEach( function ( button ) {
		var label = button.querySelector( '.wprev-coupon__label' );
		var coupon = button.closest( '.wprev-coupon' );
		var status = coupon.querySelector( '[data-wprev-copy-status]' );
		var timer;

		button.addEventListener( 'click', function () {
			copyText( button.getAttribute( 'data-wprev-copy' ) ).then( function () {
				button.classList.add( 'is-copied' );
				label.textContent = i18n.copied;
				if ( status ) {
					status.textContent = i18n.copied;
				}
				clearTimeout( timer );
				timer = setTimeout( function () {
					button.classList.remove( 'is-copied' );
					label.textContent = i18n.copy;
					if ( status ) {
						status.textContent = '';
					}
				}, 2000 );
			} ).catch( function () {
				selectCode( coupon.querySelector( '.wprev-coupon__code' ) );
			} );
		} );
	} );
} )();
