<?php
## Включаем поддержку виджетов. Добавляем область для виджетов
//if (function_exists('register_sidebar')) {
//    register_sidebar(array(
//        'before_widget' => '<aside>',
//        'after_widget'  => '</aside>',
//        'before_title'  => '<h3>',
//        'after_title'   => '</h3>',
//    ));
//}

## Включение миниатюр записи
add_theme_support('post-thumbnails');

if (!current_theme_supports('menus')) {
    add_theme_support('menus');
}

set_post_thumbnail_size(200, 200, true); // Normal post thumbnails

## Отменяем обертку картинок в тег `<p>` в контенте
add_filter('the_content', 'remove_img_ptags_func');
function remove_img_ptags_func($content)
{
    return preg_replace('/<p>\s*((?:<a[^>]+>)?\s*<img[^>]+>\s*(?:<\/a>)?)\s*<\/p>/i', '\1', $content);
}

global $wp_embed;
add_filter('widget_text', array(
    & $wp_embed,
    'run_shortcode'
), 8);
add_filter('widget_text', array(
    & $wp_embed,
    'autoembed'
), 8);

## Удаляет "Рубрика: ", "Метка: " и т.д. из заголовка архива
add_filter( 'get_the_archive_title', function( $title ){
    return preg_replace('~^[^:]+: ~', '', $title );
});
