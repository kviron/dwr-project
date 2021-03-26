<?php
use function Env\env;

class Site {
    /**
     * @var array
     * Params teheme
     */
    public static $theme = [];

    /**
     * @var array
     * Params teheme
     */
    public static $vars = [];


    /**
     * Set init params
     */
    public static function init(){
        self::setThemeUrl(get_template_directory());
        self::setThemePath(get_template_directory_uri());
        self::setThemeName(get_template_directory_uri());
    }

    /**
     * Get url site
     */
    public static function setThemeUrl($url_site){
        self::$theme['url'] = $url_site;
    }

    /**
     * Get url site
     */
    public static function setThemeName($url_site){
        self::$theme['name'] = env('WP_THEME_NAME');
    }

    /**
     * Get path theme
     */
    public static function setThemePath($path_theme){
        self::$theme['path'] = $path_theme;
    }

}
