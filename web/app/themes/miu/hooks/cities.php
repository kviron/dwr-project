<?php
add_action('header_top-row', 'link_cities', 5);

function link_cities()
{
    get_template_part('components/city');
}


add_action('wp_footer', 'cityModal', 5);
function cityModal()
{
    get_template_part('components/window-modal');
}
