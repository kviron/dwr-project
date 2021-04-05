<?php

class Site {
    /**
     * @var array
     */
    public static $theme = [];

    /**
     * @var array
     * Params vars
     */
    public static $vars = [];

    public static $item = [];

    public static function init($items_default = 'template-parts/items/item-')
    {
        self::set_theme_url(get_template_directory());
        self::set_theme_path(get_template_directory_uri());
        self::$item['path'] = $items_default;
    }

    public static function set_theme_url($url_site)
    {
        self::$theme['url'] = $url_site;
    }

    /**
     * Set path theme
     */
    public static function set_theme_path($path_theme)
    {
        self::$theme['path'] = $path_theme;
    }


    public static function the_posts($post_type, $args = [])
    {
        global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

        $counter           = 0;
        $tmp_default       = self::$item['path'] . $post_type;

        $args['post_type'] = $args['post_type'] ?? get_query_var('post_type');
        $state             = $args['state'] ?? 'private';
        $tmp_path          = $args['template'] ?? self::$item['path'] . $args['post_type'];

        if ($state === 'private') {
            self::loop_posts($wp_query, $tmp_path, $args);
        } else if ($state === 'global') {
            if (!isset($args['paged'])) {
                $args['paged'] = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
            }

            if (!isset($args['posts_per_page'])) {
                $args['posts_per_page'] = get_query_var('paged') ?? 1;
            }

            $query = new WP_Query($args);
            self::loop_posts($query, $tmp_path, $args);
        }

        wp_reset_postdata();
    }

    public static function get_posts($post_type, $args = [])
    {
        global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

        $args['post_type'] = $args['post_type'] ?? get_query_var('post_type');
        $state             = $args['state'] ?? 'private';
        $tmp_path          = $args['template'] ?? self::$item['path'] . $args['post_type'];

        if ($state === 'private') {
            $query = $wp_query->have_posts();
        } else if ($state === 'global') {
            $query = new WP_Query($args);
        }

        wp_reset_postdata();

        return $query;
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

    public static function get_template($_template_file, $args = [], $require_once = false)
    {
        global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

        ob_start();

        if (is_array($args)) {
            extract($args, EXTR_SKIP);
        }

        if (is_array($wp_query->query_vars)) {
            extract($wp_query->query_vars, EXTR_SKIP);
        }

        if (isset($s)) {
            $s = esc_attr($s);
        }

        if ($require_once) {
            require_once self::$theme['path'] . '/' . $_template_file . '.php';
        } else {
            require self::$theme['path'] . '/' . $_template_file . '.php';
        }
        echo ob_get_clean();
    }

    static function loop_posts($query, $tmp_path, $args = [])
    {
        $counter = 0;
        while ($query->have_posts()) {
            $query->the_post();

            echo $args['container']['start'] ?? null;

            self::get_template(
                $tmp_path,
                [
                    'post'          => $post,
                    'thumbnail_url' => get_the_post_thumbnail_url($post->ID, $args['thumbnail_size'] ?? null),
                    'class'         => $args['class'] ?? null,
                    'counter'       => $counter,
                ]);

            echo $args['container']['end'] ?? null;

            $counter++;
        }
    }

}
