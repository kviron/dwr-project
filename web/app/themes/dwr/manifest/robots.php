<?php
add_action( 'do_robotstxt', 'my_robotstxt' );
function my_robotstxt(){
    $site_url = get_site_url();
    $lines = [
        'User-agent: *',
        'Disallow: /wp-admin/',
        'Allow: /wp-admin/admin-ajax.php',
        'Disallow: /wp-includes/',
        "Disallow: */comments",
        "Disallow: /cgi-bin",             # Стандартная папка на хостинге.
	    "Disallow: /?" ,                  # Все параметры запроса на главной.
	    "Disallow: *?s=",                 # Поиск.
        "Disallow: *&s=",                 # Поиск.
        "Disallow: /search",              # Поиск.
	    "Disallow: /author/",             # Архив автора.
        "Disallow: */embed",              # Все встраивания.
	    "Disallow: */page/",              # Все виды пагинации.
        "Disallow: */xmlrpc.php",         # Файл WordPress API
	    "Disallow: *utm*=",               # Ссылки с utm-метками
        "Disallow: *openstat=",           # Ссылки с метками openstat
        "",
        'Sitemap: '.$site_url.'/wp-sitemap.xml',
    ];

    echo implode( "\r\n", $lines );

    die; // обрываем работу PHP
}