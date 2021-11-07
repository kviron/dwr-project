<?php

/**
 * Class Template for render templates
 */
class Template
{
    public static function render($file, $args)
    {
        ob_start();
        self::get_template($file, $args);
        echo ob_get_clean();
    }

    public static function get($file, $args)
    {
        ob_start();
        self::get_template($file, $args);
        return ob_get_clean();
    }

    private static function get_template($file, $args = []): void
    {
        if ($args) {
            extract($args, EXTR_OVERWRITE);
        }

        $filePath = preg_replace('|([/]+)|s', '/', get_template_directory() . '/' . $file . '.php');

        if (file_exists($filePath)) {
            require $filePath;
        }
    }
}
