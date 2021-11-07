<?php
/**
 * Регистрация новой таксономии title
 */
add_action('init', 'create_taxonomy_title');
function create_taxonomy_title()
{
    // список параметров: wp-kama.ru/function/get_taxonomy_labels
    register_taxonomy('genre', [ 'titles' ], [
        'label'                 => 'Жанры', // определяется параметром $labels->name
        'labels'                => [
            'name'              => __('Жанры', 'dwr-theme'),
            'singular_name'     => __('Жанр', 'dwr-theme'),
            'search_items'      => __('Найти жанр', 'dwr-theme'),
            'all_items'         => __('Все жанры', 'dwr-theme'),
            'view_item '        => __('Посмотреть жанр', 'dwr-theme'),
            'parent_item'       => __('Родительский жанр', 'dwr-theme'),
            'parent_item_colon' => __('Родительские жанры:', 'dwr-theme'),
            'edit_item'         => __('Изменить жанр', 'dwr-theme'),
            'update_item'       => __('Обновить', 'dwr-theme'),
            'add_new_item'      => __('Добавить жанр', 'dwr-theme'),
            'new_item_name'     => __('Новое имя жанра', 'dwr-theme'),
            'menu_name'         => __('Жанры', 'dwr-theme'),
        ],
        'description'           => '', // описание таксономии
        'public'                => true,
        // 'publicly_queryable'    => null, // равен аргументу public
        // 'show_in_nav_menus'     => true, // равен аргументу public
        // 'show_ui'               => true, // равен аргументу public
        // 'show_in_menu'          => true, // равен аргументу show_ui
        // 'show_tagcloud'         => true, // равен аргументу show_ui
        // 'show_in_quick_edit'    => null, // равен аргументу show_ui
        'hierarchical'          => true,
        'rewrite'               => true,
        //'query_var'             => $taxonomy, // название параметра запроса
        'capabilities'          => [],
        'meta_box_cb'           => true, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
        'show_admin_column'     => true, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
        'show_in_rest'          => true, // добавить в REST API
//        'rest_base'             => null, // $taxonomy
        // '_builtin'              => false,
        //'update_count_callback' => '_update_post_term_count',
    ]);

    // список параметров: wp-kama.ru/function/get_taxonomy_labels
    register_taxonomy('years', [ 'titles' ], [
        'label'                 => 'Год', // определяется параметром $labels->name
        'labels'                => [
            'name'              => __('Год', 'dwr-theme'),
            'singular_name'     => __('Год', 'dwr-theme'),
            'search_items'      => __('Найти год', 'dwr-theme'),
            'all_items'         => __('Все года', 'dwr-theme'),
            'view_item '        => __('Посмотреть жанр', 'dwr-theme'),
            'parent_item'       => __('Родительский жанр', 'dwr-theme'),
            'parent_item_colon' => __('Родительские жанры:', 'dwr-theme'),
            'edit_item'         => __('Изменить жанр', 'dwr-theme'),
            'update_item'       => __('Обновить', 'dwr-theme'),
            'add_new_item'      => __('Добавить год', 'dwr-theme'),
            'new_item_name'     => __('Новое имя жанра', 'dwr-theme'),
            'menu_name'         => __('Год', 'dwr-theme'),
        ],
        'description'           => '', // описание таксономии
        'public'                => true,
        // 'publicly_queryable'    => null, // равен аргументу public
        // 'show_in_nav_menus'     => true, // равен аргументу public
        // 'show_ui'               => true, // равен аргументу public
        // 'show_in_menu'          => true, // равен аргументу show_ui
        // 'show_tagcloud'         => true, // равен аргументу show_ui
        // 'show_in_quick_edit'    => null, // равен аргументу show_ui
        'hierarchical'          => false,

        'rewrite'               => true,
        //'query_var'             => $taxonomy, // название параметра запроса
        'capabilities'          => [],
        'meta_box_cb'           => true, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
        'show_admin_column'     => true, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
        'show_in_rest'          => true, // добавить в REST API
        //        'rest_base'             => null, // $taxonomy
        // '_builtin'              => false,
        //'update_count_callback' => '_update_post_term_count',
    ]);

    register_taxonomy('season', [ 'titles' ], [
        'label'                 => 'Сезон', // определяется параметром $labels->name
        'labels'                => [
            'name'              => __('Сезоны', 'dwr-theme'),
            'singular_name'     => __('Сезон', 'dwr-theme'),
            'search_items'      => __('Найти сезон', 'dwr-theme'),
            'all_items'         => __('Все сезоны', 'dwr-theme'),
            'view_item '        => __('Посмотреть сезон', 'dwr-theme'),
            'parent_item'       => __('Родительский сезон', 'dwr-theme'),
            'parent_item_colon' => __('Родительские сезоны:', 'dwr-theme'),
            'edit_item'         => __('Изменить сезон', 'dwr-theme'),
            'update_item'       => __('Обновить', 'dwr-theme'),
            'add_new_item'      => __('Добавить сезон', 'dwr-theme'),
            'new_item_name'     => __('Новое имя сезона', 'dwr-theme'),
            'menu_name'         => __('Сезоны', 'dwr-theme'),
        ],
        'description'           => '', // описание таксономии
        'public'                => true,
        // 'publicly_queryable'    => null, // равен аргументу public
        // 'show_in_nav_menus'     => true, // равен аргументу public
        // 'show_ui'               => true, // равен аргументу public
        // 'show_in_menu'          => true, // равен аргументу show_ui
        // 'show_tagcloud'         => true, // равен аргументу show_ui
        // 'show_in_quick_edit'    => null, // равен аргументу show_ui
        'hierarchical'          => false,

        'rewrite'               => true,
        //'query_var'             => $taxonomy, // название параметра запроса
        'capabilities'          => [],
        'meta_box_cb'           => true, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
        'show_admin_column'     => true, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
        'show_in_rest'          => true, // добавить в REST API
        //        'rest_base'             => null, // $taxonomy
        // '_builtin'              => false,
        //'update_count_callback' => '_update_post_term_count',
    ]);
}


/**
 * Регистрация нового типа поста title
 */
add_action('init', 'register_post_types_titles');
function register_post_types_titles()
{
    register_post_type('titles', [
        'label'         => null,
        'labels'        => [
            'name'               => __('Тайтлы', 'dwr-theme'),      // основное название для типа записи
            'singular_name'      => __('Тайтл', 'dwr-theme'),                  // название для одной записи этого типа
            'add_new'            => __('Добавить тайтл', 'dwr-theme'),         // для добавления новой записи
            'add_new_item'       => __('Добавление тайтла', 'dwr-theme'),       // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => __('Редактирование тайтла', 'dwr-theme'),   // для редактирования типа записи
            'new_item'           => __('Новый тайтл', 'dwr-theme'),            // текст новой записи
            'view_item'          => __('Смотреть тайтл', 'dwr-theme'),         // для просмотра записи этого типа.
            'search_items'       => __('Искать тайтл', 'dwr-theme'),           // для поиска по этим типам записи
            'not_found'          => __('Не найдено', 'dwr-theme'),            // если в результате поиска ничего не было найдено
            'not_found_in_trash' => __('Не найдено в корзине', 'dwr-theme'),  // если не было найдено в корзине
            'parent_item_colon'  => __('Родительский тайтл', 'dwr-theme'),                      // для родителей (у древовидных типов)
            'menu_name'          => __('Тайтлы', 'dwr-theme'),      // название меню
        ],
        'description'   => '',
        'public'        => true,
        // 'publicly_queryable'  => null,                    // зависит от public
        // 'exclude_from_search' => null,                    // зависит от public
        // 'show_ui'             => null,                    // зависит от public
        // 'show_in_nav_menus'   => null,                    // зависит от public
        'show_in_menu'  => true,                             // показывать ли в меню адмнки
        // 'show_in_admin_bar'   => null,                    // зависит от show_in_menu
        'show_in_rest'  => true,                            // Включаем поддержку Gutenberg
        'rest_base'     => 'titles',               // $post_type. C WP 4.7
        'menu_position' => null,
        'menu_icon'     => null,
        //'capability_type'   => 'post',
        //'capabilities'      => 'post',                     // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null,                       // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'  => false,
        'supports'      => [
            'title',
            'editor',
            'thumbnail'
        ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'has_archive'   => false,
        'rewrite'       => true,
        'query_var'     => false,
    ]);
}
