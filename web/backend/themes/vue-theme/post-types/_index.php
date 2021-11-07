<?php
/**
* Раздел подключения новых типов постов
*/
//require_once 'post-example.php';

/**
 * Добавляем типы записей в результат поиска
 */
//add_action('pre_get_posts', 'get_services_search_filter');
function get_services_search_filter($query)
{
    if (!is_admin() && $query->is_main_query() && $query->is_search) {
        $query->set('post_type', [
          'page' #Указать типы постов
        ]);
    }
}
