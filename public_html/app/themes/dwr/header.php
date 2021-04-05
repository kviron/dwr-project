<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 *
 * @package WordPress
 * @subpackage DWR_Theme
 */
?>
<!doctype html>
<html lang="<?php bloginfo('language'); ?>">
    <head>
        <?php wp_head(); ?>
    </head>
<body <?php body_class() ?>>
    <div class="root" id="root">
    <?php
    /**
     * Hook site_header
     * 
     */
    do_action('site_header');
    ?>


