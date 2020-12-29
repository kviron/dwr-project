<?php

add_action('header_top-row', 'registr_top_menu', 10);

function registr_top_menu()
{
    wp_nav_menu([
        'theme_location'       => 'header_top-menu',
        'menu'                 => '',
        'container'            => 'nav',
        'container_class'      => 'header__top-menu',
        'container_id'         => false,
        'container_aria_label' => 'Header menu',
        'menu_class'           => 'top-menu',
        'menu_id'              => false,
        'echo'                 => true,
        'fallback_cb'          => 'wp_page_menu',
        'before'               => '',
        'after'                => '',
        'link_before'          => '',
        'link_after'           => '',
        'items_wrap'           => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'depth'                => 0,
        'walker'               => '',
    ]);
}

add_action('header_bottom-row', 'getLogotype', 5);
function getLogotype()
{
    get_template_part('components/logotype');
}

