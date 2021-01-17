<!doctype html>
<html lang="<?php bloginfo('language'); ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Keywords" content="HTML, META, метатег, тег, поисковая система">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body class="<?php body_class(); ?>">

<header class="header">
    <div class="header__top-row">
        <div class="container">
            <?php
            /**
             * header_top-row hook.
             *
             * @see link_cities() - 5
             * @see registr_top_menu() - 10
             */
            do_action('header_top-row'); ?>
        </div>
    </div>
    <div class="header__bottom-row">
        <div class="container">
            <?php
            /**
             * header_bottom-row hook.
             *
             * @see getLogotype() - 5
             */
            do_action('header_bottom-row'); ?>
        </div>
    </div>
</header>
