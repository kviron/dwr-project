<?php
/**
 * Обьявление констант
 */
define('THEME_VERSION', '0.0.1');
define('THEME_PATH', get_template_directory());
define('THEME_URL', get_template_directory_uri());
define('THEME_ASSETS', THEME_URL . '/assets');

require_once __DIR__ . '/classes/_index.php';

require_once __DIR__ . '/settings/_index.php';

require_once __DIR__ . '/post-types/_index.php';

require_once __DIR__ . '/custom-fields/_init.php';
