<?php
## CSS для страницы входа (login)
## Нужно создать файл 'wp-login.css' в папке темы
add_action('login_head', 'my_loginCSS');
function my_loginCSS() {
    echo '<link rel="stylesheet" type="text/css" href="'. get_template_directory_uri() .'/wp-login.css"/>';
}