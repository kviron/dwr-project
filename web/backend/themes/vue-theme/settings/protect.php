<?php
## Полное Удаление версии WP
## Также нужно удалить файл readme.html в корне сайта
remove_action('wp_head', 'wp_generator'); // из заголовка
add_filter('the_generator', '__return_empty_string'); // из фидов и URL



// Отключим выводи ошибок на странице авторизации
add_filter('login_errors', 'login_obscure_func');
function login_obscure_func(){
    return 'Ошибка: вы ввели неправильный логин или пароль.';
}

## Удаление файлов license.txt и readme.html для защиты
if( is_admin() && ! defined('DOING_AJAX') ){
    $license_file = ABSPATH .'/license.txt';
    $readme_file = ABSPATH .'/readme.html';

    if( file_exists($license_file) && current_user_can('manage_options') ){
        $deleted = unlink($license_file) && unlink($readme_file);

        if( ! $deleted  )
            $GLOBALS['readmedel'] = 'Не удалось удалить файлы: license.txt и readme.html из папки `'. ABSPATH .'`. Удалите их вручную!';
        else
            $GLOBALS['readmedel'] = 'Файлы: license.txt и readme.html удалены из из папки `'. ABSPATH .'`.';

        add_action( 'admin_notices', function(){  echo '<div class="error is-dismissible"><p>'. $GLOBALS['readmedel'] .'</p></div>'; } );
    }
}