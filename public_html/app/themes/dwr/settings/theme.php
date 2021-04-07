<?php

/**
 * Включение миниатюр записи
 */
add_theme_support('post-thumbnails');

/**
 * Включение поддержку меню
 */
if (!current_theme_supports('menus')) {
    add_theme_support('menus');
}

/**
 * Удаляет "Рубрика: ", "Метка: " и т.д. из заголовка архива
 */
add_filter( 'get_the_archive_title', function( $title ){
    return preg_replace('~^[^:]+: ~', '', $title );
});


/**
 * Add custom background
 */
$defaults = array(
    'default-color'          => '#fff',
    'default-image'          => '',
    'wp-head-callback'       => '_custom_background_cb',
    'admin-head-callback'    => '',
    'admin-preview-callback' => ''
);
add_theme_support( 'custom-background', $defaults );

/**
 * Включает поддержку html5 разметки для списка комментариев,
 * формы комментариев, формы поиска, галереи и т.д. Где нужно включить разметку указывается во втором параметре:
 */
add_theme_support( 'html5', array(
    'comment-list',
    'comment-form',
    'search-form',
    'gallery',
    'caption',
    'script',
    'style',
) );

/**
 * Поддержка тега title
 */
add_theme_support( 'title-tag' );

/**
 * Add support logo
 */
add_theme_support( 'custom-logo', [
    'height'      => 190,
    'width'       => 190,
    'flex-width'  => true,
    'flex-height' => true,
    'header-text' => '',
    'unlink-homepage-logo' => true, // WP 5.5
] );

/**
 * Включает поддержку широкого выравнивания для картинок у блоков Гутенберга
 */
add_theme_support( 'align-wide' );


