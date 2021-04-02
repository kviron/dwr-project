<?php


/**
 * Включаем поддержку svg
 */
add_filter('upload_mimes', 'svg_upload_allow');
function svg_upload_allow($mimes)
{
    $mimes['svg'] = 'image/svg+xml';

    return $mimes;
}

/**
 * Исправление MIME типа для SVG файлов.
 *
 * @param        $data
 * @param        $file
 * @param        $filename
 * @param        $mimes
 * @param string $real_mime
 *
 * @return mixed
 */
function fix_svg_mime_type($data, $file, $filename, $mimes, $real_mime = '')
{
    if (version_compare($GLOBALS['wp_version'], '5.1.0', '>='))
        $dosvg = in_array($real_mime, [
            'image/svg',
            'image/svg+xml'
        ]);
    else
        $dosvg = ( '.svg' === strtolower(substr($filename, -4)) );

    if ($dosvg) {

        // разрешим
        if (current_user_can('manage_options')) {

            $data['ext']  = 'svg';
            $data['type'] = 'image/svg+xml';
        } // запретим
        else {
            $data['ext'] = $type_and_ext['type'] = false;
        }
    }
    return $data;
}

add_filter('wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5);


/**
 * Формирует данные для отображения SVG как изображения в медиабиблиотеке.
 *
 * @param $response
 *
 * @return mixed
 */
function show_svg_in_media_library($response)
{
    if ($response['mime'] === 'image/svg+xml') {
        // С выводом названия файла
        $response['image'] = [
            'src' => $response['url'],
        ];
    }
    return $response;
}

add_filter('wp_prepare_attachment_for_js', 'show_svg_in_media_library');


/**
 * Отключаем постоянную проверку обновлений что бы ускорить админку
 *
 * @param string $value
 *
 * @return mixed|string
 */
function update_active_plugins($value = '')
{

    if (( isset($value->response) ) && ( count($value->response) )) {

        // Get the list cut current active plugins
        $active_plugins = get_option('active_plugins');
        if ($active_plugins) {

            //  Here we start to compare the $value->response
            //  items checking each against the active plugins list.
            foreach ($value->response as $plugin_idx => $plugin_item) {

                // If the response item is not an active plugin then remove it.
                // This will prevent WordPress from indicating the plugin needs update actions.
                if (!in_array($plugin_idx, $active_plugins))
                    unset($value->response[$plugin_idx]);
            }
        } else {
            // If no active plugins then ignore the inactive out of date ones.
            foreach ($value->response as $plugin_idx => $plugin_item) {
                unset($value->response);
            }
        }
    }
    return $value;
}

add_filter('transient_update_plugins', 'update_active_plugins');

/**
 * Установим максимальное количество ревизий записи
 */
if (!defined('WP_POST_REVISIONS')) define('WP_POST_REVISIONS', 5);


/**
 * Убираем лишние стили
 */
function disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}

add_action('init', 'disable_emojis');

function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, [ 'wpemoji' ]);
    } else {
        return [];
    }
}


/**
 * Удаляем уведомление об обновлении WordPress для всех кроме админа
 */
add_action('admin_head', function () {
    if (!current_user_can('manage_options')) {
        remove_action('admin_notices', 'update_nag', 3);
        remove_action('admin_notices', 'maintenance_nag', 10);
    }
});


/**
 * Добавляет миниатюры записи в таблицу записей в админке
 */
if (1) {
    add_action('init', 'add_post_thumbs_in_post_list_table', 20);
    function add_post_thumbs_in_post_list_table()
    {
        // проверим какие записи поддерживают миниатюры
        $supports = get_theme_support('post-thumbnails');

        // $ptype_names = array('post','page'); // указывает типы для которых нужна колонка отдельно

        // Определяем типы записей автоматически
        if (!isset($ptype_names)) {
            if ($supports === true) {
                $ptype_names = get_post_types([ 'public' => true ], 'names');
                $ptype_names = array_diff($ptype_names, [ 'attachment' ]);
            } // для отдельных типов записей
            elseif (is_array($supports)) {
                $ptype_names = $supports[0];
            }
        }

        // добавляем фильтры для всех найденных типов записей
        foreach ($ptype_names as $ptype) {
            add_filter("manage_{$ptype}_posts_columns", 'add_thumb_column');
            add_action("manage_{$ptype}_posts_custom_column", 'add_thumb_value', 10, 2);
        }
    }

    // добавим колонку
    function add_thumb_column($columns)
    {
        // подправим ширину колонки через css
        add_action('admin_notices', function () {
            echo '
			<style>
				.column-thumbnail{ width:80px; text-align:center; }
			</style>';
        });

        $num = 1; // после какой по счету колонки вставлять новые

        $new_columns = [ 'thumbnail' => __('Thumbnail') ];

        return array_slice($columns, 0, $num) + $new_columns + array_slice($columns, $num);
    }

    // заполним колонку
    function add_thumb_value($colname, $post_id)
    {
        if ('thumbnail' == $colname) {
            $width = $height = 45;

            // миниатюра
            if ($thumbnail_id = get_post_meta($post_id, '_thumbnail_id', true)) {
                $thumb = wp_get_attachment_image($thumbnail_id, [
                    $width,
                    $height
                ], true);
            } // из галереи...
            elseif (
            $attachments = get_children(
                [
                    'post_parent'    => $post_id,
                    'post_mime_type' => 'image',
                    'post_type'      => 'attachment',
                    'numberposts'    => 1,
                    'order'          => 'DESC',
                ])
            ) {
                $attach = array_shift($attachments);
                $thumb  = wp_get_attachment_image($attach->ID, [
                    $width,
                    $height
                ], true);
            }

            echo empty($thumb) ? ' ' : $thumb;
        }
    }
}
