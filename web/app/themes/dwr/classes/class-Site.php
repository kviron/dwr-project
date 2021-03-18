<?php


class Site {
    /**
     * @var string
     */
    public static $path;

    /**
     * @var string
     */
    public static $url;

    /**
     * Get url site
     */
    public static function setUrl($url_site){
        self::$url = $url_site;
    }

    /**
     * Get path theme
     */
    public static function setPath($path_theme){
        self::$path = $path_theme;
    }

}

Site::setPath(get_template_directory());
Site::setUrl(get_template_directory_uri());
