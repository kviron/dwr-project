<?php

use function Env\env;

class Site
{
    /**
     * @var array
     */
    public static $theme = [];

    /**
     * @var array
     * Params teheme
     */
    public static $vars = [];

    public static function init(){
        self::set_theme_url(get_template_directory());
        self::set_theme_path(get_template_directory_uri());
        self::set_theme_name(get_template_directory_uri());
    }

    public static function set_theme_url($url_site){
        self::$theme['url'] = $url_site;
    }


    /**
     * Set url site
     */
//    public static function set_theme_name($url_site){
//        self::$theme['name'] = env('WP_THEME_NAME');
//    }

    /**
     * Set path theme
     */
    public static function set_theme_path($path_theme){

        self::$theme['path'] = $path_theme;
    }


    public static function the_posts($post_type, $args = [])
    {
        global $wp_query;
        $container = [];
        $counter = 0;
        $tmp_default = 'template-parts/items/item-' . $post_type;
        $args['post_type'] = $post_type ?? 'post';

        if (isset($args['container'])) {
            $container['start'] = $args['container']['start'];
            $container['end'] = $args['container']['end'];
        }

        $query = new WP_Query($args);

        while ($query->have_posts()) {
            $query->the_post();
            global $post;

            echo $container['start'] ?? null;

            get_template_part(
                $args['template'] ?? $tmp_default, $args['name'] ?? null,
                [
                    'post'    => $post,
                    'class'   => $args['class'] ?? null,
                    'fields'  => function_exists('get_field_objects') ? get_field_objects($post->ID) : null,
                    'counter' => $counter,
                ]
            );

            echo $container['end'] ?? null;

            $counter++;
        }

        wp_reset_postdata();
    }

    public static function ge_posts($post_type, $args = [])
    {
        $args['post_type'] = $post_type ?? 'post';

        $counter = 0;
        $posts = [];

        $query = new WP_Query($args);

        while ($query->have_posts()) {
            $query->the_post();
            global $post;

            $posts[$counter]['url'] = function_exists('get_permalink') ? get_permalink($post->ID) : null;
            $posts[$counter]['thumbnail'] = function_exists('get_the_post_thumbnail_url') ? get_the_post_thumbnail_url($post->ID) : null;
            $posts[$counter]['post'] = $post;
            $posts[$counter]['fields'] = function_exists('get_field_objects') ? get_field_objects($post->ID) : null;

            $counter++;
        }

        wp_reset_postdata();

        return $posts;
    }

    public static function get_type_page()
    {
        if (is_front_page()) {
            return 'front_page';
        } elseif (is_archive()) {
            return 'archive';
        } elseif (is_single()) {
            return 'single';
        } elseif (is_page()) {
            return 'page';
        }
        return 'diff';
    }

}
