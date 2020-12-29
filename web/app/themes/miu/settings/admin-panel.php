<?php
/**
 * Отключаем принудительную проверку новых версий WP, плагинов и темы в админке,
 * чтобы она не тормозила, когда долго не заходил и зашел...
 * Все проверки будут происходить незаметно через крон или при заходе на страницу: "Консоль > Обновления".
 *
 * @see https://wp-kama.ru/filecode/wp-includes/update.php
 * @author Kama (https://wp-kama.ru)
 * @version 1.1
 */
if( is_admin() ){
    // отключим проверку обновлений при любом заходе в админку...
    remove_action( 'admin_init', '_maybe_update_core' );
    remove_action( 'admin_init', '_maybe_update_plugins' );
    remove_action( 'admin_init', '_maybe_update_themes' );

    // отключим проверку обновлений при заходе на специальную страницу в админке...
    remove_action( 'load-plugins.php', 'wp_update_plugins' );
    remove_action( 'load-themes.php', 'wp_update_themes' );

    // оставим принудительную проверку при заходе на страницу обновлений...
    //remove_action( 'load-update-core.php', 'wp_update_plugins' );
    //remove_action( 'load-update-core.php', 'wp_update_themes' );

    // внутренняя страница админки "Update/Install Plugin" или "Update/Install Theme" - оставим не мешает...
    //remove_action( 'load-update.php', 'wp_update_plugins' );
    //remove_action( 'load-update.php', 'wp_update_themes' );

    // событие крона не трогаем, через него будет проверяться наличие обновлений - тут все отлично!
    //remove_action( 'wp_version_check', 'wp_version_check' );
    //remove_action( 'wp_update_plugins', 'wp_update_plugins' );
    //remove_action( 'wp_update_themes', 'wp_update_themes' );

    /**
     * отключим проверку необходимости обновить браузер в консоли - мы всегда юзаем топовые браузеры!
     * эта проверка происходит раз в неделю...
     * @see https://wp-kama.ru/function/wp_check_browser_version
     */
    add_filter( 'pre_site_transient_browser_'. md5( $_SERVER['HTTP_USER_AGENT'] ), '__return_empty_array' );
}

## Добавляет ссылку на страницу всех настроек в пункт меню админки "Настройки"
//add_action('admin_menu', 'all_settings_link');
function all_settings_link(){
    add_options_page( __('All Settings'), __('All Settings'), 'manage_options', 'options.php?foo' );
}

add_action( 'admin_head', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        remove_action( 'admin_notices', 'update_nag', 3 );
        remove_action( 'admin_notices', 'maintenance_nag', 10 );
    }
} );



## Удаление метабоксов на странице редактирования записи
add_action('admin_menu','remove_default_post_screen_metaboxes');
function remove_default_post_screen_metaboxes() {
    // для постов
    //remove_meta_box( 'postcustom','post','normal' ); // произвольные поля
    remove_meta_box( 'postexcerpt','post','normal' ); // цитата
    remove_meta_box( 'commentstatusdiv','post','normal' ); // комменты
    remove_meta_box( 'trackbacksdiv','post','normal' ); // блок уведомлений
    remove_meta_box( 'slugdiv','post','normal' ); // блок альтернативного названия статьи
    remove_meta_box( 'authordiv','post','normal' ); // автор

    // для страниц
    //remove_meta_box( 'postcustom','page','normal' ); // произвольные поля
    remove_meta_box( 'postexcerpt','page','normal' ); // цитата
    remove_meta_box( 'commentstatusdiv','page','normal' ); // комменты
    remove_meta_box( 'trackbacksdiv','page','normal' ); // блок уведомлений
    remove_meta_box( 'slugdiv','page','normal' ); // блок альтернативного названия статьи
    remove_meta_box( 'authordiv','page','normal' ); // автор
}

##  отменим показ выбранного термина наверху в checkbox списке терминов
add_filter( 'wp_terms_checklist_args', 'set_checked_ontop_default', 10 );
function set_checked_ontop_default( $args ) {
    // изменим параметр по умолчанию на false
    if( ! isset($args['checked_ontop']) )
        $args['checked_ontop'] = false;

    return $args;
}

## Удаление табов "Все рубрики" и "Часто используемые" из метабоксов рубрик (таксономий) на странице редактирования записи.
add_action('admin_print_footer_scripts', 'hide_tax_metabox_tabs_admin_styles', 99);
function hide_tax_metabox_tabs_admin_styles(){
    $cs = get_current_screen();
    if( $cs->base !== 'post' || empty($cs->post_type) ) return; // не страница редактирования записи
    ?>
    <style>
        .postbox div.tabs-panel{ max-height:1200px; border:0; }
        .category-tabs{ display:none; }
    </style>
    <?php
}



## Добавляем все типы записей в виджет "Прямо сейчас" в консоли
add_action( 'dashboard_glance_items' , 'add_right_now_info' );
function add_right_now_info( $items ){

    if( ! current_user_can('edit_posts') ) return $items; // выходим

    // типы записей
    $args = array( 'public' => true, '_builtin' => false );

    $post_types = get_post_types( $args, 'object', 'and' );

    foreach( $post_types as $post_type ){
        $num_posts = wp_count_posts( $post_type->name );
        $num       = number_format_i18n( $num_posts->publish );
        $text      = _n( $post_type->labels->singular_name, $post_type->labels->name, intval( $num_posts->publish ) );

        $items[] = "<a href=\"edit.php?post_type=$post_type->name\">$num $text</a>";
    }

    // таксономии
    $taxonomies = get_taxonomies( $args, 'object', 'and' );

    foreach( $taxonomies as $taxonomy ){
        $num_terms = wp_count_terms( $taxonomy->name );
        $num       = number_format_i18n( $num_terms );
        $text      = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name , intval( $num_terms ) );

        $items[] = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$num $text</a>";
    }

    // пользователи
    global $wpdb;

    $num  = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users");
    $text = _n( 'User', 'Users', $num );

    $items[] = "<a href='users.php'>$num $text</a>";

    return $items;
}


## Отключаем пинги на свои же посты
add_action('pre_ping', 'kama_disable_inner_ping');
function kama_disable_inner_ping( &$links ){
    foreach( $links as $k => $val )
        if( false !== strpos( $val, str_replace('www.', '', $_SERVER['HTTP_HOST']) ) )
            unset( $links[$k] );
}


## Фильтр элементо втаксономии для метабокса таксономий в админке.
## Позволяет удобно фильтровать (искать) элементы таксономии по назанию, когда их очень много
add_action( 'admin_print_scripts', 'my_admin_term_filter', 99 );
function my_admin_term_filter() {
    $screen = get_current_screen();

    if( 'post' !== $screen->base ) return; // только для страницы редактирвоания любой записи
    ?>
    <script>
        jQuery(document).ready(function($){
            var $categoryDivs = $('.categorydiv');

            $categoryDivs.prepend('<input type="search" class="fc-search-field" placeholder="фильтр..." style="width:100%" />');

            $categoryDivs.on('keyup search', '.fc-search-field', function (event) {

                var searchTerm = event.target.value,
                    $listItems = $(this).parent().find('.categorychecklist li');

                if( $.trim(searchTerm) ){
                    $listItems.hide().filter(function () {
                        return $(this).text().toLowerCase().indexOf(searchTerm.toLowerCase()) !== -1;
                    }).show();
                }
                else {
                    $listItems.show();
                }
            });
        });
    </script>
    <?php
}



## Изменение текста в подвале админ-панели
add_filter('admin_footer_text', 'footer_admin_func');
function footer_admin_func () {
    echo 'Разработка темы: <a href="https://vk.com/drozzi_drozzi" target="_blank">MA-Yeast</a>. Работает на <a href="http://wordpress.org" target="_blank">WordPress</a>.';
}



## Шорткоды в виджете "Текст"
if( ! is_admin() ){
    add_filter('widget_text', 'do_shortcode', 11);
}


## Добавляет в профиль поля: AIM, Yahoo IM, Jabber / Google Talk
add_filter('user_contactmethods', 'add_contactmethod');
function add_contactmethod( $contactmethods ) {
    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['facebook'] = 'Facebook';

    return $contactmethods;
}

## Отключает Гутенберг (новый редактор блоков в WordPress).
## ver: 1.2
if( 'disable_gutenberg' ){
    remove_theme_support( 'core-block-patterns' ); // WP 5.5

    add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );

    // отключим подключение базовых css стилей для блоков
    // ВАЖНО! когда выйдут виджеты на блоках или что-то еще, эту строку нужно будет комментировать
    remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );

    // Move the Privacy Policy help notice back under the title field.
    add_action( 'admin_init', function(){
        remove_action( 'admin_notices', [ 'WP_Privacy_Policy_Content', 'notice' ] );
        add_action( 'edit_form_after_title', [ 'WP_Privacy_Policy_Content', 'notice' ] );
    } );
}
