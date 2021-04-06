<?php
/**
 * Configuration overrides for WP_ENV === 'dev'
 */

use Roots\WPConfig\Config;
use function Env\env;

Config::define('WPLANG', 'ru_RU');
Config::define('WP_DEFAULT_THEME', env('WP_THEME_NAME'));

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_DISPLAY', true);
Config::define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
Config::define('SCRIPT_DEBUG', true);

ini_set('display_errors', '1');

// Enable plugin and theme updates and installation from the admin
Config::define('DISALLOW_FILE_MODS', false);
