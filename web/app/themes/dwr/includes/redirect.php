<?php
//Редирект со всех страниц на главную для лэндинга
//add_action('template_redirect', 'redirect_to_homepage');

function redirect_to_homepage()
{
    $homepage_id = get_option('page_on_front');
    $admin_id = get_option('page_admin');
    if (!is_page($homepage_id && get_current_screen())) {
        wp_redirect($_SERVER['REQUEST_URI'], 301);
    }
}