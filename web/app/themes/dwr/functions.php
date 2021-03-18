<?php
/**
 * Add classes
 */
require_once get_template_directory()."/classes/_init.php";

/**
 * Add carbon-fields plugin
 */
require_once Site::$path."/custom-fields/init.php";

/**
 * Add settings theme
 */
require_once Site::$path."/settings/_index.php";

/**
 * Add post-types files
 */
require_once Site::$path."/post-types/_index.php";

/**
 * Add manifest and seo files
 */
require_once Site::$path."/manifest/_index.php";

/**
 * Add includes
 */
require_once Site::$path."/includes/_index.php";

