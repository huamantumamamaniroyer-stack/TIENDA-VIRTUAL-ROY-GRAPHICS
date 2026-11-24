/**
 * One-click "Plugin Installation & Demo Import".
 *
 * Status -> install missing TGMPA plugins -> activate inactive ones -> confirm WooCommerce
 * -> import each demo product -> finish -> "Visit Site".
 */
( function () {
	'use strict';

	var config = window.automotiveCarDealerDemoImport;

	if ( ! config || window.automotiveCarDealerDemoImportBound ) {
		return;
	}

	// Guard against the script being printed twice, which would bind duplicate handlers.
	window.automotiveCarDealerDemoImportBound = true;

	var i18n    = config.i18n || {};
	var running = false;

	function format( template ) {
		var args = Array.prototype.slice.call( arguments, 1 );

		return String( template ).replace( /%(\d+)\$[sd]/g, function ( match, position ) {
			var value = args[ position - 1 ];
			return undefined === value ? match : value;
		} );
	}

	function StepError( message ) {
		this.message = message;
	}

	/**
	 * POSTs one step to admin-ajax.php and resolves with its data, or rejects with a StepError.
	 */
	function request( step, params ) {
		var body = new window.FormData();

		body.append( 'action', config.prefix + step );
		body.append( 'nonce', config.nonce );

		Object.keys( params || {} ).forEach( function ( key ) {
			body.append( key, params[ key ] );
		} );

		return window.fetch( config.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			body: body
		} ).then( function ( response ) {
			return response.text();
		}, function () {
			throw new StepError( i18n.genericError );
		} ).then( function ( text ) {
			var json;

			try {
				json = JSON.parse( text );
			} catch ( e ) {
				throw new StepError( i18n.invalidResponse );
			}

			if ( ! json || ! json.success ) {
				throw new StepError( ( json && json.data && json.data.message ) || i18n.genericError );
			}

			return json.data;
		} );
	}

	/**
	 * Runs fn( item, index ) for each item, one after another.
	 */
	function sequence( items, fn ) {
		return items.reduce( function ( chain, item, index ) {
			return chain.then( function () {
				return fn( item, index );
			} );
		}, Promise.resolve() );
	}

	function Flow( wrapper ) {
		this.wrapper = wrapper;
		this.button  = wrapper.querySelector( '.wprev-demo-import-button' );
		this.status  = wrapper.querySelector( '.wprev-demo-import-status' );
	}

	Flow.prototype.setButton = function ( label ) {
		this.button.textContent = label;
	};

	Flow.prototype.setStatus = function ( message, type ) {
		this.status.textContent = message || '';
		this.status.className   = 'wprev-demo-import-status' + ( type ? ' is-' + type : '' );
	};

	Flow.prototype.start = function () {
		var flow = this;

		running = true;
		flow.wrapper.classList.add( 'is-running' );
		flow.button.disabled = true;
		flow.button.setAttribute( 'aria-busy', 'true' );

		var visit = flow.wrapper.querySelector( '.wprev-demo-import-visit' );
		if ( visit ) {
			visit.parentNode.removeChild( visit );
		}

		flow.setButton( i18n.checking );
		flow.setStatus( '' );

		request( 'status' )
			.then( function ( state ) {
				return flow.installPlugins( state );
			} )
			.then( function () {
				// Re-read the state so activation works on what is really installed now.
				return request( 'status' );
			} )
			.then( function ( state ) {
				return flow.activatePlugins( state );
			} )
			.then( function () {
				return request( 'status' );
			} )
			.then( function ( state ) {
				return flow.importProducts( state );
			} )
			.then( function () {
				flow.setButton( i18n.finishing );
				return request( 'finish' );
			} )
			.then( function ( data ) {
				flow.complete( data.url );
			} )
			.catch( function ( error ) {
				flow.fail( error instanceof StepError ? error.message : i18n.genericError );
			} );
	};

	Flow.prototype.installPlugins = function ( state ) {
		var flow    = this;
		var pending = state.plugins.filter( function ( plugin ) {
			return ! plugin.installed;
		} );

		if ( ! pending.length ) {
			return Promise.resolve();
		}

		flow.setButton( i18n.installing );

		return sequence( pending, function ( plugin, index ) {
			flow.setStatus( format( i18n.installingOne, plugin.name, index + 1, pending.length ) );
			return request( 'install_plugin', { slug: plugin.slug } );
		} );
	};

	Flow.prototype.activatePlugins = function ( state ) {
		var flow    = this;
		var missing = state.plugins.filter( function ( plugin ) {
			return ! plugin.installed;
		} );

		if ( missing.length ) {
			return Promise.reject( new StepError( format( i18n.notInstalled, missing[ 0 ].name ) ) );
		}

		var pending = state.plugins.filter( function ( plugin ) {
			return ! plugin.active;
		} );

		if ( ! pending.length ) {
			return Promise.resolve();
		}

		flow.setButton( i18n.activating );

		return sequence( pending, function ( plugin, index ) {
			flow.setStatus( format( i18n.activatingOne, plugin.name, index + 1, pending.length ) );
			return request( 'activate_plugin', { slug: plugin.slug } );
		} );
	};

	Flow.prototype.importProducts = function ( state ) {
		var flow     = this;
		var inactive = state.plugins.filter( function ( plugin ) {
			return ! plugin.active;
		} );

		if ( inactive.length ) {
			return Promise.reject( new StepError( format( i18n.notActive, inactive[ 0 ].name ) ) );
		}

		if ( ! state.woocommerce ) {
			return Promise.reject( new StepError( i18n.noWooCommerce ) );
		}

		var failures = [];

		flow.setButton( i18n.importing );

		// A failed product does not stop the others; retrying later skips the ones already imported.
		return sequence( state.products, function ( product, index ) {
			flow.setStatus( format( i18n.importingOne, product.name, index + 1, state.products.length ) );

			return request( 'import_product', { index: index } ).catch( function ( error ) {
				failures.push( error instanceof StepError ? error.message : product.name );
			} );
		} ).then( function () {
			if ( failures.length ) {
				throw new StepError( failures.join( ' ' ) + ' ' + i18n.productsFailed );
			}
		} );
	};

	Flow.prototype.complete = function ( url ) {
		var link = document.createElement( 'a' );

		link.className   = 'button button-primary wprev-demo-import-button wprev-demo-import-visit';
		link.href        = url;
		// A new tab keeps the admin open and avoids the admin -> front end view-transition error in Chrome.
		link.target      = '_blank';
		link.rel         = 'noopener';
		link.textContent = i18n.visit;

		this.button.parentNode.replaceChild( link, this.button );
		this.wrapper.classList.remove( 'is-running' );
		this.wrapper.classList.add( 'is-complete' );
		running = false;

		if ( ! config.redirect ) {
			this.setStatus( i18n.done, 'success' );
			return;
		}

		// Keep the button disabled-looking while we leave, so it is not clicked mid-redirect.
		link.setAttribute( 'aria-disabled', 'true' );
		link.style.pointerEvents = 'none';
		this.setStatus( i18n.redirecting, 'success' );

		window.setTimeout( function () {
			window.location.href = config.redirect;
		}, 1500 );
	};

	Flow.prototype.fail = function ( message ) {
		this.button.disabled = false;
		this.button.removeAttribute( 'aria-busy' );
		this.button.classList.remove( 'button-link', 'wprev-demo-import-rerun' );
		this.button.classList.add( 'button-primary' );
		this.setButton( this.button.getAttribute( 'data-label' ) || i18n.start );
		this.wrapper.classList.remove( 'is-running' );
		this.setStatus( message + ' ' + i18n.retryHint, 'error' );
		running = false;
	};

	document.addEventListener( 'click', function ( event ) {
		var button = event.target.closest ? event.target.closest( 'button.wprev-demo-import-button' ) : null;

		if ( ! button ) {
			return;
		}

		event.preventDefault();

		if ( running || button.disabled ) {
			return;
		}

		new Flow( button.closest( '.wprev-demo-import' ) ).start();
	} );
}() );
