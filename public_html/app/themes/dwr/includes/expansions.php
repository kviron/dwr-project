<?php
//add_action('wp_head', 'show_template'); // перед шапкой
// add_action('wp_footer', 'show_template'); // в подвале
function show_template(){
    global $template;
    echo $template;
}