<?php
# Отключение провайдера карт сайтов: пользователи и таксономии
add_filter( 'wp_sitemaps_add_provider', 'kama_remove_sitemap_provider', 10, 2 );
function kama_remove_sitemap_provider( $provider, $name ){

    // отключаем архивы пользователей
    if( in_array( $name, ['users'] ) )
        return false;

    return $provider;
}