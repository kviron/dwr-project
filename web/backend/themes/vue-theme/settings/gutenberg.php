<?php

/**
 * Подключение кастомных стилей для гутенберга
 */
add_action( 'after_setup_theme', 'gutenberg_setup_theme' );
function gutenberg_setup_theme(){
    add_theme_support( 'editor-styles' );
    add_editor_style( 'style-editor.css' );
}
