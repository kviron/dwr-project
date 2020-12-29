<?php
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Сайт',
        'menu_title' => 'Настройки сайта',
        'menu_slug'  => 'site',
        'capability' => 'edit_posts',
        'redirect'   => false
    ));

    acf_add_options_sub_page(array(
        'page_title'  => 'Контакты',
        'menu_title'  => 'Контакты',
        'menu_slug'   => 'contacts',
        'post_id'     => 'contacts',
        'parent_slug' => 'site',
    ));
}
