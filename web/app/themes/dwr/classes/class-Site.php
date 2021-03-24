<?php

class Site
{
    /**
     * @var string
     */
    public static $theme = [];

    /**
     * @var string
     */
    public static $vars = [];

    /**
     * @var array
     */
    public static $phones;

    /**
     * @var array
     */
    public static $emails;

    /**
     * @var array
     */
    public static $address;

    /**
     * Get path theme
     */
    public static function init()
    {
        self::$theme['path'] = get_template_directory() . '/';
        self::$theme['url']  = get_template_directory_uri() . '/';
    }

    public static function thePosts($post_type, $args = [])
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

    public static function getPosts($post_type, $args = [])
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

    public static function getTypePage()
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
