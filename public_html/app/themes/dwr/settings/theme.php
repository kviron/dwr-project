<?php

/**
 * Включение миниатюр записи
 */
add_theme_support('post-thumbnails');
if (!current_theme_supports('menus')) {
    add_theme_support('menus');
}

/**
 * Удаляет "Рубрика: ", "Метка: " и т.д. из заголовка архива
 */
add_filter( 'get_the_archive_title', function( $title ){
    return preg_replace('~^[^:]+: ~', '', $title );
});
