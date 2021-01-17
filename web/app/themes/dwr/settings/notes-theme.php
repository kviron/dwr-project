<?php
## Произвольный виджет в консоли в админ-панели
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
function my_custom_dashboard_widgets() {
    wp_add_dashboard_widget('custom_help_widget', 'Заметки темы', 'custom_dashboard_help');
}

function custom_dashboard_help() {
    echo '<p>Добро пожаловать в тему "Моя тема"! Тут некоторые заметки по теме.';
}