const hamburger = document.querySelector( '.hamburger' );
const header = document.querySelector( '.header' );
const body = document.querySelector( 'body' );

if ( hamburger ) {
	hamburger.addEventListener( 'click', ( event ) => {
		body.classList.toggle( 'stun' );
		header.classList.toggle( 'header--menu-open' );

		if ( header.classList.contains( 'header--float' ) && ! header.classList.contains( 'header--fixed' ) ) {
			header.classList.toggle( 'header--color-section' );
		}

		event.currentTarget.classList.toggle( 'hamburger--active' );
	} );
}

