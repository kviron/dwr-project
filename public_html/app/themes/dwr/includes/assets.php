<?php
/**
 * Изменяет URL расположения jQuery файла только для фронт-энда
 */
if( ! is_admin() ){
    add_action('wp_enqueue_scripts', 'jquery_enqueue_func', 11);
    function jquery_enqueue_func(){
        wp_deregister_script('jquery');
        wp_register_script('jquery', "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js", false, null, true);
        wp_enqueue_script('jquery');
    }
}

/**
 * Подключение скрипта html5 для IE с cdn
 */
add_action('wp_head', 'IEhtml5_shim_func');
function IEhtml5_shim_func(){
    echo '<!--[if lt IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->';
    // или если нужна еще и поддержка при печати
    echo '<!--[if lt IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script><![endif]-->';
}

//Enqueue styles
add_action( 'wp_enqueue_scripts', 'load_style', 11 );
function load_style() {
    wp_enqueue_style( 'vendor-css', THEME_ASSETS . '/css/vendors.css', false, '1.0' );
    wp_enqueue_style( 'app-css', THEME_ASSETS . '/css/app.css', 'vendor-css', '1.0' );
}

//Enqueue scripts
add_action( 'wp_enqueue_scripts', 'load_scripts', 20 );
function load_scripts() {
    wp_enqueue_script( 'vendors-js', THEME_ASSETS . '/js/vendors.js', 'jquery', '1.0', true );
    wp_enqueue_script( 'app-js', THEME_ASSETS . '/js/app.js', 'jquery', '1.0', true );
}



