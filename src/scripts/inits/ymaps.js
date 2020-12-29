// Yandex api
import ymaps from 'ymaps';
// const ymaps = await import('ymaps')

window.onload = function () {

// Yandex map API config
	function createMapYandex( address, coordinates1, coordinates2, idMap )
	{
		ymaps
				.load( 'https://api-maps.yandex.ru/2.1/?lang=ru_RU' )
				.then( maps => {
					const mainMap = new maps.Map( idMap, {
								center: [ coordinates1, coordinates2 ],
								zoom: 12,
								controls: []
							},
							{ yandexMapDisablePoiInteractivity: true, },
							{
								searchControlProvider: 'yandex#search'
							} );

					const placemark = new maps.Placemark( mainMap.getCenter(),
							{
								hintContent: address,
							},
							// {
							// 	iconLayout: 'default#image',
							// 	iconImageHref: '/wp-content/themes/valkyria/assets/ico/location.svg',
							// 	iconImageSize: [ 50, 50 ],
							// 	iconImageOffset: [ -8, -72 ]
							// }
					);

					mainMap.behaviors.disable( 'scrollZoom' );

					mainMap.geoObjects.add( placemark );
				} );
	}

	let maps = document.querySelectorAll( '.contact .contact__map' )

	setTimeout( () => {
		maps.forEach( map => {

			let mapId = map.id,
					mapCoordinateWeight = map.dataset.mapCoordinatWeight,
					mapCoordinateLongitude = map.dataset.mapCoordinatLongitude,
					mapAddress = map.dataset.address;

			// createMapYandex(mapAddress, mapCoordinateWeight, mapCoordinateLongitude, mapId)


		} )

		createMapYandex( 'ОТК «Текстиль Профи-Иваново»\n' +
				'153005, г. Иваново, ул. Сосновая, д. 1', 57.011068, 41.006844, 'map' )

	}, 1000 );


};