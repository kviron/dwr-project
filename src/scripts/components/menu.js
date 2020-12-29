export default class Menu
{
	constructor( menu )
	{
		this.menu = menu;
		this.toggleMenu( menu )
		this.hideMenuOnMissClick( menu )
	}

	toggleMenu( menu )
	{
		const menuBlock = document.querySelector( `[data-menu=${ menu }]` )
		const menuTrigger = document.querySelectorAll( `[data-menu-trigger=${ menu }]` )

		if ( menuBlock && menuTrigger ) {
			const closeButton = menuBlock.querySelector('.menu__close')


			menuTrigger.forEach(button => {
				button.addEventListener('click', (event) => {

					if ( menuBlock.classList.contains( 'menu--hidden' ) ) {
						this.hiddenMenus()

						menuBlock.classList.remove( 'menu--hidden' )
						menuBlock.classList.add( 'menu--open' )
						menuTrigger.forEach(item => {
							item.classList.add('menu-switcher--active')
						})

					} else {
						this.hiddenMenus()
					}
				})

			})

			if ( closeButton ) {
				closeButton.addEventListener('click', (event) => {
					this.hiddenMenus()
				})
			}
		}
	}

	hiddenMenus()
	{
		const menus = document.querySelectorAll( `[data-menu]` )
		const menuButtons = document.querySelectorAll( `[data-menu-trigger]` )


		menus.forEach( menu => {
			menu.classList.remove( 'menu--open' )
			menu.classList.add( 'menu--hidden' )
		} )

		menuButtons.forEach(item => {
			item.classList.remove('menu-switcher--active')
		})
	}

	hideMenuOnMissClick(menu)
	{
		const currentMenu = document.querySelector( `[data-menu-trigger=${ menu }]` )

		document.addEventListener('click', (event) => {
			if ( !event.target.closest('[data-menu-trigger]')) this.hiddenMenus()
		})
	}

}