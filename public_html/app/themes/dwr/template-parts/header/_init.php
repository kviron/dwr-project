<?php

add_action('site_header', 'get_header_site');
function get_header_site(){
    Site::get_template('template-parts/header/header');
}

add_action('wp_head', 'get_meta_header_site');
function get_meta_header_site(){
    Site::get_template('template-parts/header/meta-section');
}
