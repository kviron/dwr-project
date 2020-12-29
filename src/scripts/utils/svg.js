function requireAll( r ) {
	r.keys().forEach( r );
}

requireAll( require.context( '../../ico_sprite/', true, /\.svg$/ ) );

const host = window.location.origin;
const containerSvg = document.querySelector( '#svg-icons' );

fetch( `${ host }/sprite.svg` )

	.then( ( res ) => {
		return res.text();
	} )
	.then( ( data ) => {
		if ( containerSvg ) {
			containerSvg.innerHTML = data;
		} else {
			const containerSvg = document.createElement( 'div' );

			containerSvg.id = 'svg-icons';

			document.body.insertAdjacentElement( 'beforeend', containerSvg );

			containerSvg.innerHTML = data;
		}
	} )
	.then(
		() => {
			const svg = document.querySelectorAll( '.icon .icon__svg use' );
		}
	);

