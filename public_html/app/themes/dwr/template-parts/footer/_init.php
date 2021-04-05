<?php

add_action('site_footer', 'get_footer_site');
function get_footer_site(){
    Site::get_template('template-parts/footer/footer');
}

add_action('site_footer', 'get_footer_scripts_site');
function get_footer_scripts_site(){
    Site::get_template('template-parts/footer/footer-scripts');
}
