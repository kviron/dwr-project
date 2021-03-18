<?php
/**
 * Add classes
 */
require_once get_template_directory() . "/classes/_init.php";

Site::init();

/**
 * Add carbon-fields plugin
 */
require Site::$theme['path'] . "/custom-fields/init.php";

/**
 * Add settings theme
 */
require Site::$theme['path'] . "/settings/_index.php";

/**
 * Add post-types files
 */
require Site::$theme['path'] . "/post-types/_index.php";

/**
 * Add manifest and seo files
 */
require Site::$theme['path'] . "/manifest/_index.php";

/**
 * Add includes
 */
require Site::$theme['path'] . "/includes/_index.php";

