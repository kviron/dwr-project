<?php
## Изменяет URL расположения jQuery файла только для фронт-энда
if( ! is_admin() ){
    add_action('wp_enqueue_scripts', 'jquery_enqueue_func', 11);
    function jquery_enqueue_func(){
        wp_deregister_script('jquery');
        wp_register_script('jquery', "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js", false, null, true);
        wp_enqueue_script('jquery');
    }
}

// Подключение скрипта html5 для IE с cdn
add_action('wp_head', 'IEhtml5_shim_func');
function IEhtml5_shim_func(){
    echo '<!--[if lt IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->';
    // или если нужна еще и поддержка при печати
    echo '<!--[if lt IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script><![endif]-->';
}

//Подключаем модалки Wordpress с ajax
//add_thickbox();