import 'core-js/es6/array';
import 'core-js/es6/number';

// Support ForEach
if ( 'NodeList' in window && ! NodeList.prototype.forEach ) {
	NodeList.prototype.forEach = function( callback, thisArg ) {
		thisArg = thisArg || window;
		for ( let i = 0; i < this.length; i++ ) {
			callback.call( thisArg, this[ i ], i, this );
		}
	};
}

// Support Matches
if ( ! Element.prototype.matches ) {
	Element.prototype.matches = Element.prototype.msMatchesSelector ||
		Element.prototype.webkitMatchesSelector;
}

// Support Closest
if ( ! Element.prototype.closest ) {
	Element.prototype.closest = function( s ) {
		let el = this;

		do {
			if ( Element.prototype.matches.call( el, s ) ) {
				return el;
			}
			el = el.parentElement || el.parentNode;
		} while ( el !== null && el.nodeType === 1 );
		return null;
	};
}

// Support Filter
if ( ! Array.prototype.filter ) {
	Array.prototype.filter = function( func, thisArg ) {
		'use strict';
		if ( ! ( ( typeof func === 'Function' || typeof func === 'function' ) && this ) ) {
			throw new TypeError();
		}

		let len = this.length >>> 0,
			res = new Array( len ), // preallocate array
			t = this,
			c = 0,
			i = -1;

		let kValue;
		if ( thisArg === undefined ) {
			while ( ++i !== len ) {
				// checks to see if the key was set
				if ( i in this ) {
					kValue = t[ i ]; // in case t is changed in callback
					if ( func( t[ i ], i, t ) ) {
						res[ c++ ] = kValue;
					}
				}
			}
		} else {
			while ( ++i !== len ) {
				// checks to see if the key was set
				if ( i in this ) {
					kValue = t[ i ];
					if ( func.call( thisArg, t[ i ], i, t ) ) {
						res[ c++ ] = kValue;
					}
				}
			}
		}

		res.length = c; // shrink down array to proper size
		return res;
	};
}

// Support Includes
if ( ! String.prototype.includes ) {
	String.prototype.includes = function() {
		'use strict';
		return String.prototype.indexOf.apply( this, arguments ) !== -1;
	};
}
