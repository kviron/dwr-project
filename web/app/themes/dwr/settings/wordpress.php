<?php
//SVG ------------------------------------------------------------------------------------------------------------------
add_filter( 'upload_mimes', 'svg_upload_allow' );

# Добавляет SVG в список разрешенных для загрузки файлов.
function svg_upload_allow( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';

    return $mimes;
}

add_filter( 'wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5 );

# Исправление MIME типа для SVG файлов.
function fix_svg_mime_type( $data, $file, $filename, $mimes, $real_mime = '' ){

    // WP 5.1 +
    if( version_compare( $GLOBALS['wp_version'], '5.1.0', '>=' ) )
        $dosvg = in_array( $real_mime, [ 'image/svg', 'image/svg+xml' ] );
    else
        $dosvg = ( '.svg' === strtolower( substr($filename, -4) ) );

    // mime тип был обнулен, поправим его
    // а также проверим право пользователя
    if( $dosvg ){

        // разрешим
        if( current_user_can('manage_options') ){

            $data['ext']  = 'svg';
            $data['type'] = 'image/svg+xml';
        }
        // запретим
        else {
            $data['ext'] = $type_and_ext['type'] = false;
        }

    }

    return $data;
}

add_filter( 'wp_prepare_attachment_for_js', 'show_svg_in_media_library' );

# Формирует данные для отображения SVG как изображения в медиабиблиотеке.
function show_svg_in_media_library( $response ) {
    if ( $response['mime'] === 'image/svg+xml' ) {
        // С выводом названия файла
        $response['image'] = [
            'src' => $response['url'],
        ];
    }
    return $response;
}


add_filter('transient_update_plugins', 'update_active_plugins');    // Hook for 2.8.+
//add_filter('option_update_plugins', 'update_active_plugins');    // Hook for 2.7.x
function update_active_plugins( $value = '' ){

    if( (isset($value->response)) && (count($value->response)) ){

        // Get the list cut current active plugins
        $active_plugins = get_option('active_plugins');
        if ($active_plugins) {

            //  Here we start to compare the $value->response
            //  items checking each against the active plugins list.
            foreach($value->response as $plugin_idx => $plugin_item) {

                // If the response item is not an active plugin then remove it.
                // This will prevent WordPress from indicating the plugin needs update actions.
                if (!in_array($plugin_idx, $active_plugins))
                    unset($value->response[$plugin_idx]);
            }
        }
        else {
            // If no active plugins then ignore the inactive out of date ones.
            foreach($value->response as $plugin_idx => $plugin_item) {
                unset($value->response);
            }
        }
    }
    return $value;
}



//Установим максимальное количество ревизий записи
if( ! defined('WP_POST_REVISIONS') ) define('WP_POST_REVISIONS', 5);

## Повышаем резкость для создаваемых миниатюр (only jpg). Только для GD библиотеки...
add_filter('image_make_intermediate_size', 'sharpen_resized_image_files', 900 );
function sharpen_resized_image_files( $resized_file ){

    if( ! function_exists('imagecreatefromstring') )
        return $resized_file; // The GD image library is not installed.

    // грузим картинку. аналог старой функции wp_load_image()
    if(1){
        // Увеличиваем размер памяти до максимума.
        if( function_exists('wp_raise_memory_limit') ) wp_raise_memory_limit( 'image' );

        $image = imagecreatefromstring( file_get_contents($resized_file) );
    }

    if( ! is_resource($image) )
        return $resized_file; // error_loading_image

    if( ! $size = @ getimagesize($resized_file) )
        return $resized_file; // invalid_image - Could not read image size

    list( $orig_w, $orig_h, $orig_type ) = $size;

    switch( $orig_type ){
        case IMAGETYPE_JPEG:
            $matrix = array(
                array(-1, -1, -1),
                array(-1, 16, -1),
                array(-1, -1, -1),
            );

            $divisor = array_sum(array_map('array_sum', $matrix));
            $offset = 0;
            imageconvolution( $image, $matrix, $divisor, $offset );
            imagejpeg( $image, $resized_file, apply_filters( 'jpeg_quality', 90, 'edit_image' ) );
            break;

        case IMAGETYPE_PNG:
            return $resized_file;

        case IMAGETYPE_GIF:
            return $resized_file;
    }

    return $resized_file;
}

//Убираем лишние стили
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}


//Удалит версии подключаемых файлов - обычно используеться во время разработки
//function rm_query_string( $src ){
//    $parts = explode( '?ver', $src );
//    return $parts[0];
//}
//
//if ( !is_admin() ) {
//    add_filter( 'script_loader_src', 'rm_query_string', 15, 1 );
//    add_filter( 'style_loader_src', 'rm_query_string', 15, 1 );
//}