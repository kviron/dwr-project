<?php


class Site {
    /**
     * @var array
     * Params teheme
     */
    public static $theme = [];


    /**
     * Set init params
     */
    public static function init(){
        self::setUrlTheme(get_template_directory());
        self::setPathTheme(get_template_directory_uri());
    }

    /**
     * Get url site
     */
    public static function setUrlTheme($url_site){
        self::$theme['url'] = $url_site;
    }

    /**
     * Get path theme
     */
    public static function setPathTheme($path_theme){
        self::$theme['path'] = $path_theme;
    }

}
