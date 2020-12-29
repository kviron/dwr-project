<?php

function load_style() {
    wp_enqueue_style( 'vendor-css', get_template_directory_uri() . '/assets/css/vendors.css', false, '1.0' );
    wp_enqueue_style( 'app-css', get_template_directory_uri() . '/assets/css/app.css', 'vendor-css', '1.0' );
}

add_action( 'wp_enqueue_scripts', 'load_style', 11 );

function load_scripts() {
    wp_enqueue_script( 'vendors-js', get_template_directory_uri() . '/assets/js/vendors.js', false, '1.0', true );
    wp_enqueue_script( 'app-js', get_template_directory_uri() . '/assets/js/app.js', array('jquery'), '1.0', true );
}

add_action( 'wp_enqueue_scripts', 'load_scripts', 20 );



//Передаем данные переменные в JS  -----------------------
//add_action( 'wp_enqueue_scripts', 'add_global_vars', 99 );
//
//function add_global_vars(){
//	if (get_field('counter', 'option')){
//		$counter = get_field('counter', 'option');
//		wp_localize_script( 'app-js', 'data_counter', array(
//			'number' => $counter['number'],
//			'month' => $counter['month'],
//			'year' => $counter['year'],
//			'time' => $counter['time'],
//			'places' => $counter['places']
//		) );
//	}
//}